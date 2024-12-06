<?php
class UserController extends Controller {

    private $auth_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();
    }

    public function index() {
        $head = array('title' => 'Login / Signup', 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');

        $data = $this->auth_model->getUser(Session::getUser()) ?? [];
        $this->render('user', $head, $data);
    }
}
?>