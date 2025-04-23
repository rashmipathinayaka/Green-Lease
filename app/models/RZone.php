<?php
class RZone{
use Model;

protected $table = 'zone';
protected $allowedColumns = [
    'id',
    'zone_name',
];




public function getAllZones() {
    $query = "SELECT * FROM zone";
    return $this->query($query); // Executes the query and returns the results
}











}