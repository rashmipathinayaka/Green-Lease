<?php

class User
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
    ];

    public function emailExists($email)
    {
        // Use getRow to check if the email exists
        $query = "SELECT id FROM {$this->table} WHERE email = :email";
        return $this->getRow($query, ['email' => $email]);
    }

    public function findUserByUsernameOrEmail($email)
    {
        $query = "SELECT * FROM user WHERE email = :email";
        return $this->getRow($query, ['email' => $email]);
    }

    public function register($userData)
    {
        $query = "INSERT INTO {$this->table} 
                  (full_name, email, password, role_id, nic, contact_no, joined_date) 
                  VALUES (:full_name, :email, :password, :role_id, :nic, :contact_no, NOW())";
        return $this->query($query, $userData);
    }
}
