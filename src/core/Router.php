<?php
class Router {
    protected $routes = [];

    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    private function addRoute($route, $callback, $method)
    {
        $this->routes[$method][$route] = $callback;
    }

    public function get($route, $callback)
    {
        $this->addRoute($route, $callback, "get");
    }

    public function post($route, $callback)
    {
        $this->addRoute($route, $callback, 'post');
    }

    public function delete($route, $callback)
    {
        $this->addRoute($route, $callback, 'delete');
    }

    public function dispatch()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        
        $callback = $this->routes[$method][$url] ?? false;
        
        if ($callback === false) {
            die("No route found for URI: $url");
        }
        
        $callback[0] = new $callback[0];
        call_user_func($callback, $this->request, $this->response);
    }
}
?>