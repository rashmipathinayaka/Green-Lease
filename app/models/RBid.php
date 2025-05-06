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
     * @return int
     */
    public function countbids()
    {
        $query = "SELECT COUNT(*) AS total FROM bid";
        $result = $this->query($query);

        return $result ? (int) $result[0]->total : 0; 
    }

    public function getBiddingsByHarvestId($harvest_id, $capacity)
    {
        $query = "SELECT * FROM bid WHERE harvest_id = :harvest_id";
        $data = [':harvest_id' => $harvest_id];
        $bids = $this->query($query, $data);

        if (empty($bids)) {
            return []; 
        }

        $formatted_bids = array_map(function ($bid) {
            return [
                'bid_id' => $bid->id,
                'amount' => (int) $bid->amount,
                'profit' => (int) $bid->amount * (float) $bid->unit_price, 
            ];
        }, $bids);

        $selected_bids = $this->knapsack($formatted_bids, $capacity);

        $selected_bid_ids = array_column($selected_bids, 'bid_id');

        $selected = [];
        $non_selected = [];
        foreach ($bids as $bid) {
            if (in_array($bid->id, $selected_bid_ids)) {
                $selected[] = $bid;
            } else {
                $non_selected[] = $bid;
            }
        }

        usort($selected, function ($a, $b) {
            return ($b->amount * $b->unit_price) - ($a->amount * $a->unit_price);
        });

        usort($non_selected, function ($a, $b) {
            return ($b->amount * $b->unit_price) - ($a->amount * $a->unit_price);
        });

        return array_merge($selected, $non_selected);
    }

   
    private function knapsack($bids, $capacity)
    {
        if (empty($bids)) {
            return []; 
        }

        $n = count($bids);
        $dp = array_fill(0, $n + 1, array_fill(0, $capacity + 1, 0));

        
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
   