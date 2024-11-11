<?php
class Router {
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method)
    {

        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function put($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "PUT");
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method =  $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];

            $controller = new $controller();

            # TOREDO: Check if the method is POST or PUT and pass the $_POST data to the controller
            if ($method == "POST" || $method == "PUT") {
                $controller->$action($_POST);
            } else {
                $controller->$action();
            }
        } else {
            throw new \Exception("No route found for URI: $uri");
        }
    }
}
?>