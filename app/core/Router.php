<?php

namespace App\core;

class Router extends Controller {
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method) {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];  
    }

    public function get($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function dispatch() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            $this->render('404');
            return;
        }

        $controller = $this->routes[$method][$uri]['controller'];
        $action = $this->routes[$method][$uri]['action'];

        if (!class_exists($controller) || !method_exists($controller, $action)) {
            http_response_code(500);
            echo "Erreur interne : contrôleur ou action non trouvée.";
            return;
        }

        $controllerInstance = new $controller();
        $controllerInstance->$action();
    }
}
