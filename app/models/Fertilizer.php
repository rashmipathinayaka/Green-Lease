<?php

class Fertilizer
{
    use Model;

    protected $table = 'fertilizer';

    protected $allowedColumns = [
        'id',
        'name',
        'amount',
        'last_restocked',
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
        if (empty($data['last_restocked'])) {
            $this->errors['last_restocked'] = 'Last restocked date is required.';
        } elseif (!strtotime($data['last_restocked'])) {
            $this->errors['last_restocked'] = 'Invalid date format.';
        }

        return empty($this->errors);
    }

    public function getTotalFertilizerStock()
    {
        $row = $this->getrow("SELECT SUM(amount) AS total FROM fertilizer");
        return $row ? $row->total : 0;
    }
}
