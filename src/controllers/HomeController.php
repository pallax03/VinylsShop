<?php
class HomeController extends Controller {

    private $auth_model = null;
    // vinylsmodel for search
    private $vinyls_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        require_once MODELS . 'VinylsModel';
        $this->auth_model = new AuthModel();
        $this->vinyls_model = new VinylsModel();
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

        if ($this->auth_model->checkUserMail($body['mail'])) {
            if ($this->auth_model->login($body['mail'], $body['password'])) {
                $response->Success('Logged in, redirecting...');
                return;
            }
            $response->Error('User found, but password is wrong...');
        } else {
            $message = $this->auth_model->register($body['mail'], $body['password']);
            if ($message === true) {
                $this->auth_model->login($body['mail'], $body['password']);
                $response->Success('Registered, redirecting...');
                return;
            }
            $response->Error($message ?? 'Query Error, please register...');
        }
    }

    public function logout(Request $request, Response $response) {
        $this->auth_model->logout();
        $response->redirect('/');
    }

    public function forgotPassword() {
        // $this->auth_model->forgotPassword();
        echo json_encode(['error' => 'Not implemented']);
    }

    public function search(Request $request, Response $response) {
        $body = $request->getBody();
        // send json to the view (?)
    }
}
?>