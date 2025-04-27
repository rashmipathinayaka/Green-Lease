<?php

class Auth {
    private static $instance = null;
    private $isLoggedIn = false;
    private $user = null;

    private function __construct() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (isset($_SESSION['id'])) {
            $this->isLoggedIn = true;
            $this->user = $_SESSION;
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    public function hasRole($role) {
        if (!$this->isLoggedIn) {
            return false;
        }

        return isset($this->user['role']) && $this->user['role'] == $role;
    }

    public function login($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        $this->isLoggedIn = true;
        $this->user = $_SESSION;
    }

    public function logout() {
        session_destroy();
        $this->isLoggedIn = false;
        $this->user = null;
    }
} 