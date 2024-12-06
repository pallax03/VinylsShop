<?php
class HomeController extends Controller {

    private $auth_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();
    }

    public function index(Request $request, Response $response) {
        $data = $request->getBody();
        $title = $data['title'] ?? 'Home';
        $head = array('title' => $title, 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');

        $this->render('home', $head, $data);
    }

    public function login(Request $request, Response $response) {
        $body = $request->getBody();
        $message = "";

        $userExist = $this->auth_model->checkMail($body['mail']);
        if (!$userExist) {
            $result = $this->auth_model->register($body['mail'], $body['password'], isset($body['su']) ? $body['su'] : '0', isset($body['newsletter']) ? $body['newsletter'] : '1');
            if (!$result) {
                $response->Error('Error while registering');
                return ;
            }
        }
        
        $result = $this->auth_model->login($body['mail'], $body['password']);
        $message = $userExist ? "Logged in, redirecting..." : "Registered, redirecting...";

        if ($result) {
            $response->Success($message);
        } else {
            $response->Error('Credentials not valid');
        }
    }

    public function logout(Request $request, Response $response) {
        $this->auth_model->logout();
        $response->redirect('/');
    }

    public function forgotPassword() {
        // $this->model->forgotPassword();
        echo json_encode(['error' => 'Not implemented']);
    }

    public function deleteUser(Request $request, Response $response) {
        $this->auth_model->checkAuth($request->getAuthentication()); // check Authentication

        $body = $request->getBody();
        $result = $this->auth_model->deleteUser($body['id_user']);
        echo json_encode($result);
    }
}
?>