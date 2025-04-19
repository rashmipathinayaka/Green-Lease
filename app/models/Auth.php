<?php
class Auth
{
    public static function logged_in()
    {
        // Check if user is logged in (modify according to your session system)
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    public static function getUserId()
    {
        // Return current user ID from session
        return $_SESSION['user']['id'] ?? null;
    }

    public static function authenticate($email, $password)
    {
        // Your authentication logic here
        $user = new User();
        $row = $user->first(['email' => $email]);
        
        if($row && password_verify($password, $row->password)) {
            $_SESSION['user'] = $row;
            return true;
        }
        
        return false;
    }

    public static function logout()
    {
        if(isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }
}