<?php

class RUser
{
    use Model;

    protected $table = 'user';

    protected $allowedColumns = [
        'password',
        'email',
        'role_id',
        'nic',
        'contact_no',
        'full_name',
        'id',
        'joined_date',
        'propic'
    ];

    public function validate($data)
    {
        $this->errors = [];
    
        if (empty($data['full_name'])) {
            $this->errors['full_name'] = "Full name is required";
        }
    
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        }
    
        if (empty($data['nic'])) {
            $this->errors['nic'] = "NIC is required";
        }
    
        if (empty($data['contact_no'])) {
            $this->errors['contact_no'] = "Contact No is required";
        }
    
        if (empty($this->errors)) {
            return true;
        }
    
        return false;
    }
    

    public function insertsupervisor($data)
    {
        $data['role_id'] = 2; // assuming 2 is the role ID for supervisor
        $result = $this->insert($data);  // Call the insert method (assuming it returns true or false)
    
        return $result;  // Return the result (true or false)
    }
    
//for adminto t add siteheads
public function insertsitehead($data)
{
    $data['role_id'] = 2; // assuming 2 is the role ID for supervisor
    $this->insert($data); 
}

//to get the userid to the supervisor table
public function getUserIdByNic($nic)
{
    $query = "SELECT id FROM user WHERE nic = :nic LIMIT 1";
    $result = $this->query($query, ['nic' => $nic]);
    if ($result) {
        return $result[0]->id; // Access the id property of the first result (assuming results are returned as objects)
    }
    return false;
}

// Function to generate a random password
function generateRandomPassword($length = 12) {
    return bin2hex(random_bytes($length)); // Generate a random string of $length bytes and convert it to hex
}





//for profile

public function getuserbyid($userId)
{
    $query = "SELECT user.* 
              FROM user 
              JOIN supervisor ON supervisor.user_id = user.id 
              WHERE user.id = :id 
              LIMIT 1";

    $data = [':id' => $userId];
    return $this->query($query, $data)[0] ?? null;
}

public function getEmailById($id) {
    $query = "SELECT email FROM user WHERE id = :id AND role_id = 4"; 
    $data = [':id' => $id];
    $result = $this->query($query, $data);
    return $result[0]->email ?? null;
}


public function getprofilebyid($userId)
{
    $query = "SELECT * FROM user WHERE id = :id LIMIT 1";
    $data = [':id' => $userId];
    return $this->query($query, $data)[0] ?? null;


}



public function updateprofile($data, $id){
    $query = "UPDATE user SET full_name = :full_name, email = :email, 
    contact_no = :contact_no, nic = :nic WHERE id = :id";
    $data = [
        ':full_name' => $data['full_name'],
        ':email' => $data['email'],
        ':contact_no' => $data['contact_no'],
        ':nic' => $data['nic'],
        ':id' => $id
    ];
    return $this->query($query, $data);
}




//send profile picture to database
public function updateProfilePicture($userId, $filename)
{
    $imagePath = 'propics/' . $filename;

    $query = "UPDATE user SET propic = :pic WHERE id = :id";
    $data = ['pic' => $imagePath, 'id' => $userId];

    return $this->query($query, $data);
}

public function getuserinfobyid($userId)
{
    $query = "SELECT * FROM user WHERE id = :id LIMIT 1";
    $data = [':id' => $userId];
    return $this->query($query, $data)[0] ?? null;





}
}
