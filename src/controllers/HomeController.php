<?php
class HomeController extends Controller {

    private $auth_model = null;
    // vinylsmodel for search
    private $vinyls_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'VinylsModel.php';
        $this->vinyls_model = new VinylsModel();

        require_once MODELS . 'OrderModel.php';
    }

    
    public function index(Request $request, Response $response) {
        $this->redirectSuperUser();
        $title = 'Home';
        $head = array('title' => $title, 'style'=> array(''),
         'header' => "Oltre i " . OrderModel::$ShippingGoal . "€ spedizione gratuita!");

        
        $this->render('home', $head);
    }

    public function notFound(Request $request, Response $response) {
        $this->redirectSuperUser();
        $title = 'Not Found';
        $head = array('title' => $title);

        $this->render('', $head);
    }

    // All in One
    public function login(Request $request, Response $response) {
        $body = $request->getBody();

        if ($this->auth_model->checkUserMail($body['mail'])) {
            if ($this->auth_model->login($body['mail'], $body['password'], $body['remember'])) {
                $response->Success('Logged in, redirecting...');
                return;
            }
            $response->Error('User found, but password is wrong...', $body);
        } else {
            $message = $this->auth_model->register($body['mail'], $body['password']);
            if ($message === true) {
                $this->auth_model->login($body['mail'], $body['password'], $body['remember']);
                $response->Success('Registered, redirecting...');
                return;
            }
            $response->Error($message ?? 'Register Error, please try again...');
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
        // always gives OK, because there's no wrong search.
        $response->Success($this->vinyls_model->getVinyls(null, $body));
    }
    
    public function devs(Request $request, Response $response) {
        $this->redirectSuperUser();
        $data = $request->getBody();
        $title = $data['title'] ?? 'Devs';
        $head = array('title' => $title, 'style'=> array(''));

        $this->render('devs', $head, $data);
    }

    public function dashboard(Request $request, Response $response) {
        $this->render('dashboard', ['title' => 'Dashboard']);
    }

    public function reset() {
        Session::destroy();
    }
}
?>