<?php

class RSupervisor
{
    use Model;

    protected $table = 'supervisor';

    protected $allowedColumns = [
       'id',
       'zone',
       'status',
       
    ];



    public function getAllSupervisors() {
        $query = "SELECT id FROM supervisor"; // Adjust columns as needed
        return $this->query($query); // Or use your DB method to fetch all rows
    }



}