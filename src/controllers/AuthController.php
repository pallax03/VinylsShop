<?php
final class AuthController extends Controller {

    private $model = null;

    function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->model = new AuthModel();
    }

    public function login(Request $request, Response $response) {
        $body = $request->getBody();
        $message = "";

        $userExist = $this->model->checkMail($body['mail']);
        if (!$userExist) {
            $result = $this->model->register($body['mail'], $body['password'], isset($body['su']) ? $body['su'] : '0', isset($body['newsletter']) ? $body['newsletter'] : '1');
            if (!$result) {
                $response->Error('Error while registering');
                return ;
            }
        }
        
        $result = $this->model->login($body['mail'], $body['password']);
        $message = $userExist ? "Logged in, redirecting..." : "Registered, redirecting...";

        if ($result) {
            $response->Success($message);
        } else {
            $response->Error('Credentials not valid');
        }
    }

    public function logout(Request $request, Response $response) {
        $this->model->logout();
        $response->redirect('/');
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
