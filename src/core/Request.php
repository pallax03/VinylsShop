<?php
class Request
{
    private array $routeParams = [];

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getContentType()
    {
        return $_SERVER['CONTENT_TYPE'];
    }

    public function getAuthentication()
    {
        $headers = getallheaders();
        return $headers['Authorization'] ?? false;
    }

    public function getUrl()
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }
    
    public function isDelete()
    {
        return $this->getMethod() === 'delete';
    }

    private function sanitazeData($array, $type) {
        $data = [];
        foreach ($array as $key => $value) {
            $data[$key] = filter_input($type, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $data;
    }

    public function getBody()
    {
        $data = [];
        if (($this->isGet() || $this->isDelete()) && !empty($_GET)) {
            $data = $this->sanitazeData($_GET, INPUT_GET);
        }
        if ($this->isPost()) {
            $data = $this->sanitazeData($this->getContentType() === 'application/json' ?  json_decode(file_get_contents('php://input'), true) : $_POST, INPUT_POST);
        }
        return $data;
    }

    public function setRouteParams($params)
    {
        $this->routeParams = $params;
        return $this;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function getRouteParam($param, $default = null)
    {
        return $this->routeParams[$param] ?? $default;
    }
}