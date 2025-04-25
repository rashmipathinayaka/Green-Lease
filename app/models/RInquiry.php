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
    $query = "SELECT * FROM inquiry WHERE  is_deleted = '0'";  // Fetch all unsolved inquiries
    $result = $this->query($query);
    return $result;  // Return all unsolved inquiries
}


public function markassolved($id)
{
    $query = "UPDATE inquiry SET is_solved = '1' WHERE id = :id";
    $data = [':id' => $id];
    $this->query($query, $data);  // Execute the query to mark as solved


}


public function markasdeleted($data)
{
    $query = "UPDATE inquiry SET is_deleted = '1' WHERE id = :id";
    $this->query($query, $data);  // Execute the query to mark as deleted
}


}