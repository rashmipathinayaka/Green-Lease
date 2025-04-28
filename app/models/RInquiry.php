<?php 
class RInquiry
{
    use Model;  
  protected $table = 'inquiry';  
  
    protected $allowedColumns = [
        'id',
        'name',
        'email',
        'subject',
        'message',
        'is_solved',
        'is_deleted',
    ];





public function getAllunsoledInquiries()
{
    $query = "SELECT * FROM inquiry WHERE  is_deleted = '0'";  
    $result = $this->query($query);
    return $result;  
}


public function markassolved($id)
{
    $query = "UPDATE inquiry SET is_solved = '1' WHERE id = :id";
    $data = [':id' => $id];
    $this->query($query, $data);  


}


public function markasdeleted($data)
{
    $query = "UPDATE inquiry SET is_deleted = '1' WHERE id = :id";
    $this->query($query, $data);  
}


}