<?php
final class AuthController extends Controller {

    private $model = null;
    function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->model = new AuthModel();
    }

    public function login(Request $request, Response $response) {
        // JWT token for admin users
        $body = $request->getBody();
        $result = $this->model->login($body['mail'], $body['password']);
        echo json_encode($result);
        // $response->redirect('/');
    }

    public function logout(Response $response) {
        // $this->model->logout();
        echo json_encode(['error' => 'Not implemented']);
    }

    public function register() {
        // $this->model->register();
        echo json_encode(['error' => 'Not implemented']);
    }

    public function forgotPassword() {
        // $this->model->forgotPassword();
        echo json_encode(['error' => 'Not implemented']);
    }

    public function deleteUser(Request $request, Response $response) {
        $body = $request->getBody();
        $result = $this->model->deleteUser($body['id_user'], $request->getAuthentication());
        echo json_encode($result);
    }
}
