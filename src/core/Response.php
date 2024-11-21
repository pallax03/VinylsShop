<?php
class Response
{

    public function Success($message)
    {
        $this->statusCode(200);
        $this->json(['success' => $message]);
    }

    public function Error($message)
    {
        $this->statusCode(400);
        $this->json(['error' => $message]);
    }

    public function statusCode(int $code)
    {
        http_response_code($code);
    }

    public function json(array $data)
    {
        // header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}