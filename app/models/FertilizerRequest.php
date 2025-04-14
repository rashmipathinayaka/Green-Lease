<?php

class FertilizerRequest
{
    use Model;

    protected $table = 'fertilizer_request';

    protected $allowedColumns = [
        'amount',
        //'fertilizer_id',
        'project_id',
        'preferred_date',
        'status',
        'sitehead_id',
        'type',
        'remarks',
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['amount']) || !is_numeric($data['amount'])) {
            $this->errors['amount'] = 'Valid amount is required.';
        }

        if (empty($data['type'])) {
            $this->errors['type'] = 'Fertilizer type is required.';
        }

        if (empty($data['project_id'])) {
            $this->errors['project_id'] = 'Project ID is required.';
        }

        if (empty($data['preferred_date'])) {
            $this->errors['preferred_date'] = 'Preferred date is required.';
        }

        if (empty($data['sitehead_id'])) {
            $this->errors['sitehead_id'] = 'Site Head ID is required.';
        }

        // if (empty($data['remarks'])) {
        //     $this->errors['remarks'] = 'Remarks are required.';
        // }

        // Get fertilizer ID from name (not type)
        //     if (empty($this->errors)) {
        //         $fertilizerId = $this->getFertilizerIdByType($data['type']);
        //         if ($fertilizerId) {
        //             $data['fertilizer_id'] = $fertilizerId;
        //         } else {
        //             $this->errors['type'] = 'Invalid fertilizer name.';
        //         }
        //     }

        //     return empty($this->errors);
        // }

        // private function getFertilizerIdByType($name)
        // {
        //     $db = new Database();
        //     $result = $db->query("SELECT id FROM fertilizers WHERE name = :name LIMIT 1", ['name' => $name]);

        //     if ($result && is_array($result) && count($result) > 0) {
        //         return $result[0]->id;
        //     }

        return empty($this->errors);
    }
}
