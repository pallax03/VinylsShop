<?php
class UserController extends Controller {

    private $auth_model = null;
    private $user_model = null;
    private $order_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'UserModel.php';
        $this->user_model = new UserModel();

        require_once MODELS . 'OrderModel.php';
        $this->order_model = new OrderModel();
    }

    public function index() {
        $head = array('title' => 'Login / Signup', 'style'=> array(''),
         'header' => 'todo');
        
        $data['user'] = $this->user_model->getUser();
        // $data['orders'] = $this->order_model->getOrders(Session::getUser()) ?? [];
        $data['orders'] = ['a', 'b', 'c'];
        $this->render('user', $head, $data);
    }

    public function deleteUser(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->deleteUser($body['id_user'] ?? null)) {
            $response->Success('User deleted');
        } else {
            $response->Error('Not allowed to delete this user or user not found');
        }
    }
}
?>