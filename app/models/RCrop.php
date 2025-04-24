<?php

class RCrop
{
    use Model;

    protected $table = 'crop';

    protected $allowedColumns = [
        'id',
        'crop_tyoe',
       
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['crop_name'])) {
            $this->errors['crop_name'] = "Crop name is required";
        }

        if (empty($data['harvest_time'])) {
            $this->errors['harvest_time'] = "Harvest time is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }



public function getAllCrops()
    {
        $query = "SELECT * FROM crop";
        return $this->query($query);
    }

    public function getCropById($id)
    {
        $query = "SELECT * FROM crop WHERE id = :id";
        $data = [':id' => $id];
        return $this->query($query, $data);
    }

    public function cropExists($crop) {
        $query = "SELECT * FROM crop WHERE crop_type = :crop";
        $result = $this->query($query, ['crop' => $crop]);
        return !empty($result);
    }
    
    public function insertNewCrop($crop) {
        $query = "INSERT INTO crop (crop_type) VALUES (:crop)";
        $this->query($query, ['crop' => $crop]);
    }
    




}