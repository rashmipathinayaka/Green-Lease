<?php

class Router {
    private static $routes = [];
    private static $baseUrl;
    private static $publicRoutes = [
        'home' => ['controller' => 'Home', 'method' => 'index'],
        'contact' => ['controller' => 'Contact', 'method' => 'index'],
        'about' => ['controller' => 'About', 'method' => 'index'],
        'login' => ['controller' => 'Login', 'method' => 'index'],
        'signup' => ['controller' => 'Signup', 'method' => 'index'],
        'signup/register' => ['controller' => 'Signup', 'method' => 'register'],
        'reset-password' => ['controller' => 'ResetPassword', 'method' => 'index'],
        'unauthorized' => ['controller' => 'Unauthorized', 'method' => 'index'],
        'inquiry/addInquiry' => ['controller' => 'Inquiry', 'method' => 'addInquiry'],
        'marketplace' => ['controller' => 'Marketplace', 'method' => 'index'],
        'marketplace/placeBid' => ['controller' => 'Marketplace', 'method' => 'placeBid'],
        'statistics' => ['controller' => 'Statistics', 'method' => 'index']
    ];

    private static $roleRoutes = [
        'admin' => 1,
        'supervisor' => 2,
        'sitehead' => 3,
        'landowner' => 4,
        'buyer' => 5,
        'worker' => 6
    ];

    public static function init($baseUrl) {
        self::$baseUrl = $baseUrl;
    }

    public static function add($url, $controller, $method = 'index') {
        self::$routes[$url] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public static function route($url) {
        // Remove query string
        $url = explode('?', $url)[0];
        
        // Remove trailing slash
        $url = strtolower(rtrim($url, '/'));

        // If URL is empty, use home
        if(empty($url)) {
            $url = 'home';
        }

        // Split URL into segments
        $segments = explode('/', $url);
        $controllerName = ucfirst($segments[0]);
        
        // Check if this is the Inquiry controller or a public route
        if ($controllerName === 'Inquiry' || isset(self::$publicRoutes[$url])) {
            if ($controllerName === 'Inquiry') {
                $method = isset($segments[1]) ? $segments[1] : 'index';
                $params = array_slice($segments, 2);
                $controllerFile = "../app/controllers/Inquiry.php";
            } else {
                $route = self::$publicRoutes[$url];
                $controllerFile = "../app/controllers/{$route['controller']}.php";
                $controllerName = $route['controller'];
                $method = $route['method'];
                $params = [];
            }
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controllerName();
                if (method_exists($controller, $method)) {
                    call_user_func_array([$controller, $method], $params);
                    return true;
                }
            }
        }

        // Check authentication for non-public routes
        $auth = Auth::getInstance();
        if (!$auth->isLoggedIn()) {
            redirect('login');
            return false;
        }

        // If not a public route, use the standard routing
        $role = strtolower($segments[0]);
        if (isset(self::$roleRoutes[$role])) {
            // Check if user has the required role
            if (!$auth->hasRole(self::$roleRoutes[$role])) {
                redirect('unauthorized');
                return false;
            }
            
            $controllerName = isset($segments[1]) ? ucfirst($segments[1]) : 'Index';
            $method = isset($segments[2]) ? $segments[2] : 'index';
            $params = array_slice($segments, 3);

            $controllerFile = "../app/controllers/" . ucfirst($role) . "/{$controllerName}.php";
        } else {
            // If not a role directory, treat first segment as controller
            $controllerFile = "../app/controllers/{$controllerName}.php";
            $method = isset($segments[1]) ? $segments[1] : 'index';
            $params = array_slice($segments, 2);
        }

        // Check if controller exists
        if(file_exists($controllerFile)) {
            require_once $controllerFile;
            
            // Create controller instance
            $controller = new $controllerName();
            
            // Check if method exists
            if(method_exists($controller, $method)) {
                // Call the method with parameters
                call_user_func_array([$controller, $method], $params);
                return true;
            }
        }

        // If no route found, load 404 controller
        require_once "../app/controllers/_404.php";
        $controller = new _404();
        $controller->index();
        return false;
    }

    public static function redirect($url) {
        header("Location: " . self::$baseUrl . "/" . $url);
        exit();
    }

    public static function getCurrentUrl() {
        return $_GET['url'] ?? '';
    }

    public static function isActive($url) {
        return self::getCurrentUrl() === $url;
    }
} 