<?php
class UserController extends Controller {

    private $auth_model = null;
    private $order_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'OrderModel.php';
        $this->order_model = new OrderModel();
    }

    public function index() {
        $head = array('title' => 'Login / Signup', 'style'=> array(''),
         'header' => 'todo');
        

        $data['user'] = $this->auth_model->getUser(Session::getUser()) ?? [];
        // $data['orders'] = $this->order_model->getOrders(Session::getUser()) ?? [];
        $data['orders'] = ['a', 'b', 'c'];
        $this->render('user', $head, $data);
    }
}
?>