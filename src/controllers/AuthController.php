<?php
final class AuthController extends Controller {

    private $model = null;

    function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->model = new AuthModel();
    }

    public function login(Request $request, Response $response) {
        $body = $request->getBody();
        $result = $this->model->login($body['mail'], $body['password']);
        if ($result) {
            $response->Success('Logged in, redirecting...');
        } else {
            $response->Error('invalid credentials');
        }
    }

    public function logout(Request $request, Response $response) {
        $this->model->logout();
        $response->redirect('/');
    }

    public function register(Request $request, Response $response) {
        $body = $request->getBody();
        $result = $this->model->register($body['mail'], $body['password'], isset($body['su']) ? $body['su'] : '0', isset($body['newsletter']) ? $body['newsletter'] : '1');
        echo json_encode($result);
    }

    public function forgotPassword() {
        // $this->model->forgotPassword();
        echo json_encode(['error' => 'Not implemented']);
    }

    public function deleteUser(Request $request, Response $response) {
        $this->model->checkAuth($request->getAuthentication()); // check Authentication

        $body = $request->getBody();
        $result = $this->model->deleteUser($body['id_user']);
        echo json_encode($result);
    }
}
