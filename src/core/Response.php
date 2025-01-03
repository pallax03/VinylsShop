<?php
class Response
{
    public function Component($component, $data) {
        extract($data);
        include COMPONENTS . '/' . $component . '.php';
    }

    public function Success($message, $body=null) {
        $this->statusCode(200);
        $this->json([
            'message' => $message,
            'logged' => Session::isLogged() ? 'logged as '. Session::getUser() : 'not logged',
            'params' => $body
        ]);
    }

    public function Error($message, $body=null) {
        $this->statusCode(400);
        $this->json([
            'error' => $message, 
            'logged' => Session::isLogged() ? 'logged as '. Session::getUser() : 'not logged',
            'params' => $body
        ]);
    }

    public function Debug($message) {
        $this->statusCode(500);
        $this->json(['error' => $message]);
        exit();
    }

    public function statusCode(int $code) {
        http_response_code($code);
    }

    public function json(array $data) {
        // header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function redirect($url) {
        header("Location: $url");
    }
}