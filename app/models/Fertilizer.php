<?php

class Fertilizer
{
    use Model;

    protected $table = 'fertilizer';

    protected $allowedColumns = [
        'name',
        'amount',
        'lastRestocked',
    ];

    public function validate($data)
    {
        $this->errors = [];

        // Validate name
        if (empty($data['name'])) {
            $this->errors['name'] = 'Fertilizer name is required.';
        }

        // Validate amount
        if (empty($data['amount'])) {
            $this->errors['amount'] = 'Amount is required.';
        } elseif (!is_numeric($data['amount']) || $data['amount'] < 0) {
            $this->errors['amount'] = 'Amount must be a non-negative number.';
        }

        // Validate lastRestocked
        if (empty($data['lastRestocked'])) {
            $this->errors['lastRestocked'] = 'Last restocked date is required.';
        } elseif (!strtotime($data['lastRestocked'])) {
            $this->errors['lastRestocked'] = 'Invalid date format.';
        }

        return empty($this->errors);
    }

    public function getTotalFertilizerStock()
    {
        $row = $this->getrow("SELECT SUM(amount) AS total FROM fertilizer");
        return $row ? $row->total : 0;
    }
}
