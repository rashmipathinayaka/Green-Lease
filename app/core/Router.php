<?php

class Router {
    private static $routes = [];
    private static $baseUrl;
    private static $publicRoutes = [
        'marketplace' => ['role' => 'Buyer', 'controller' => 'Marketplace', 'method' => 'index'],
        'marketplace/placebid' => ['role' => 'Buyer', 'controller' => 'Marketplace', 'method' => 'placeBid']
        // Add more public routes here
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

        // Check if this is a public route
        if (isset(self::$publicRoutes[$url])) {
            $route = self::$publicRoutes[$url];
            $controllerFile = "../app/controllers/{$route['role']}/{$route['controller']}.php";
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $route['controller']();
                if (method_exists($controller, $route['method'])) {
                    call_user_func_array([$controller, $route['method']], []);
                    return true;
                }
            }
        }

        // If not a public route, use the standard routing
        $segments = explode('/', $url);
        
        // Check if first segment is a role (e.g., Buyer, Admin, etc.)
        $role = ucfirst($segments[0]);
        $controllerName = isset($segments[1]) ? ucfirst($segments[1]) : 'Index';
        $method = isset($segments[2]) ? $segments[2] : 'index';
        $params = array_slice($segments, 3);

        // Build the controller path
        $controllerPath = "../app/controllers/";
        if(is_dir("../app/controllers/" . $role)) {
            $controllerPath .= $role . "/";
            $controllerFile = $controllerPath . $controllerName . ".php";
        } else {
            // If not a role directory, treat first segment as controller
            $controllerName = $role;
            $controllerFile = $controllerPath . $controllerName . ".php";
            // Adjust method and params
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