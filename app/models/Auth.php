<?php

class Auth {
    private static $instance = null;
    private $user = null;

    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function isLoggedIn() {
        return isset($_SESSION['id']);
    }

    public function getUser() {
        if (!$this->user && $this->isLoggedIn()) {
            $userModel = new User();
            $this->user = $userModel->first(['id' => $_SESSION['id']]);
        }
        return $this->user;
    }

    public function getRole() {
        return $this->isLoggedIn() ? $_SESSION['role_id'] : null;
    }

    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            redirect('login');
            exit();
        }
    }

    public function requireRole($requiredRole) {
        $this->requireLogin();
        
        if ($this->getRole() != $requiredRole) {
            redirect('unauthorized');
            exit();
        }
    }

    public function hasRole($role) {
        return $this->getRole() == $role;
    }

    public function login($user) {
        $_SESSION['id'] = $user->id;
        $_SESSION['name'] = $user->full_name;
        $_SESSION['email'] = $user->email;
        $_SESSION['role_id'] = $user->role_id;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }
} 