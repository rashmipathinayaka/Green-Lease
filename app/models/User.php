<?php 


/**
 * User class
  */
// class User
// {
	
// 	use Model;

// 	protected $table = 'users';

// 	protected $allowedColumns = [

// 		'email',
// 		'password',
// 	];

// 	public function validate($data)
// 	{
// 		$this->errors = [];

// 		if(empty($data['email']))
// 		{
// 			$this->errors['email'] = "Email is required";
// 		}else
// 		if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
// 		{
// 			$this->errors['email'] = "Email is not valid";
// 		}
		
// 		if(empty($data['password']))
// 		{
// 			$this->errors['password'] = "Password is required";
// 		}
		
// 		if(empty($data['terms']))
// 		{
// 			$this->errors['terms'] = "Please accept the terms and conditions";
// 		}

// 		if(empty($this->errors))
// 		{
// 			return true;
// 		}

// 		return false;
// 	}
// }


class User
{
    use Model;

    protected $table = 'users';

    protected $allowedColumns = [
        'password',
        'email',
        'role_id',
        'nic',
        'contact_number',
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
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->getRow($query, ['email' => $email]);
    }

    public function register($userData)
    {
        $query = "INSERT INTO {$this->table} 
                  (full_name, email, password, role_id, nic, contact_number, joined_date) 
                  VALUES (:full_name, :email, :password, :role_id, :nic, :contact_number, NOW())";
        return $this->query($query, $userData);
    }
}
