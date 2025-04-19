<?php
class RBid
{
    use Model;

    protected $table = 'bid';

    protected $allowedColumns = [
        'id',
        'buyer_id',
        'harvest_id',
        'status',
        'amount',
        'unit_price',
    ];

    /**
     * Count the total number of bids.
     *
     * @return int
     */
    public function countbids()
    {
        $query = "SELECT COUNT(*) AS total FROM bid";
        $result = $this->query($query);

        return $result ? (int) $result[0]->total : 0; // Access total as an object property
    }

    /**
     * Fetch all biddings for a specific harvest_id and apply the Knapsack algorithm to select the best bids.
     * The selected bids are displayed at the top, sorted by profit in descending order.
     *
     * @param int $harvest_id
     * @param int $capacity Maximum allowed amount.
     * @return array Returns an array of bids with selected bids at the top, sorted by profit.
     */
    public function getBiddingsByHarvestId($harvest_id, $capacity)
    {
        // Fetch all bids for the given harvest_id
        $query = "SELECT * FROM bid WHERE harvest_id = :harvest_id";
        $data = [':harvest_id' => $harvest_id];
        $bids = $this->query($query, $data);

        if (empty($bids)) {
            return []; // Return an empty array if no bids are found
        }

        // Convert bids to the required format (array with 'amount' and 'profit')
        $formatted_bids = array_map(function ($bid) {
            return [
                'bid_id' => $bid->id,
                'amount' => (int) $bid->amount,
                'profit' => (int) $bid->amount * (float) $bid->unit_price, // Calculate profit
            ];
        }, $bids);

        // Solve the knapsack problem to get selected bids
        $selected_bids = $this->knapsack($formatted_bids, $capacity);

        // Extract the IDs of selected bids
        $selected_bid_ids = array_column($selected_bids, 'bid_id');

        // Separate selected and non-selected bids
        $selected = [];
        $non_selected = [];
        foreach ($bids as $bid) {
            if (in_array($bid->id, $selected_bid_ids)) {
                $selected[] = $bid;
            } else {
                $non_selected[] = $bid;
            }
        }

        // Sort selected bids by profit in descending order
        usort($selected, function ($a, $b) {
            return ($b->amount * $b->unit_price) - ($a->amount * $a->unit_price);
        });

        // Sort non-selected bids by profit in descending order
        usort($non_selected, function ($a, $b) {
            return ($b->amount * $b->unit_price) - ($a->amount * $a->unit_price);
        });

        // Merge selected and non-selected bids
        return array_merge($selected, $non_selected);
    }

    /**
     * Solve the knapsack problem for bids.
     *
     * @param array $bids Array of bids with 'amount' and 'profit'.
     * @param int $capacity Maximum allowed amount.
     * @return array Returns an array of selected bids.
     */
    private function knapsack($bids, $capacity)
    {
        if (empty($bids)) {
            return []; // Return an empty array if no bids are provided
        }

        $n = count($bids);
        $dp = array_fill(0, $n + 1, array_fill(0, $capacity + 1, 0));

        // Build the DP table
        for ($i = 1; $i <= $n; $i++) {
            $amount = $bids[$i - 1]['amount'];
            $profit = $bids[$i - 1]['profit'];

            for ($j = 0; $j <= $capacity; $j++) {
                if ($amount <= $j) {
                    $dp[$i][$j] = max($dp[$i - 1][$j], $dp[$i - 1][$j - $amount] + $profit);
                } else {
                    $dp[$i][$j] = $dp[$i - 1][$j];
                }
            }
        }

        // Backtrack to find selected bids
        $selected_bids = [];
        $j = $capacity;
        for ($i = $n; $i > 0; $i--) {
            if ($dp[$i][$j] != $dp[$i - 1][$j]) {
                $selected_bids[] = $bids[$i - 1];
                $j -= $bids[$i - 1]['amount'];
            }
        }

        return $selected_bids;
    }



    
}
   