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
         'header' => "Oltre i " . $_ENV['SHIPPING_GOAL'] . "€ spedizione gratuita!");
        
        $this->render('home', $head);
    }

    public function notFound(Request $request, Response $response) {
        $this->redirectSuperUser();
        $title = 'Not Found';
        $head = array('title' => $title);

        $this->render('', $head);
    }

    public function login(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->auth_model->login($body['mail'], $body['password'], $body['remember'])) {
            $response->Success('Logged in, redirecting...');
            return;
        }
        $response->Error('Wrong mail or password...', $body);
    }

    public function register(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->auth_model->register($body['mail'], $body['password'], $body['newsletter'])) {
            $this->auth_model->login($body['mail'], $body['password'], 0);
            $response->Success('Registered, logging...');
            return;
        }
        $response->Error('Register Error, please try again...');
    }

    public function loginRegister(Request $request, Response $response) {
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

    public function dashboard() {
        $this->redirectNotSuperUser();
        $this->render('admin/dashboard', ['title' => 'Dashboard']);
    }

    public function dashboardVinyls() {
        $this->redirectNotSuperUser();
        $this->render('admin/vinyls', ['title' => 'Manage Vinyls']);
    }

    public function dashboardAlbums() {
        $this->redirectNotSuperUser();
        $this->render('admin/albums', ['title' => 'Manage Albums']);
    }

    public function dashboardUsers() {
        $this->redirectNotSuperUser();
        $this->render('admin/users', ['title' => 'Manage Users']);
    }
    
    public function dashboardCoupons() {
        $this->redirectNotSuperUser();
        $this->render('admin/coupons', ['title' => 'Manage Coupons']);
    }

    public function reset() {
        Session::destroy();
    }
}
?>