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
        // $data['orders'] = $this->order_model->getOrders();
        $data['orders'] = ['a', 'b', 'c'];
        $this->render('user', $head, $data);
    }

    public function getUser(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->user_model->getUser($body['id_user'] ?? null);
        if (empty($data) || !is_array($data) || !$data) { 
            $response->Error('User not found or not allowed to see this user ' . (Session::isLogged() ? 'logged' : 'not logged'));
        } else {
            $response->Success($data);
        }
    }

    public function setDefaults(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->setDefaults($body['id_card'] ?? null, $body['id_address'] ?? null)) {
            $response->Success('Defaults set');
        } else {
            $response->Error('Not allowed to set defaults or card/address not found (usage: ?id_card=x, ?id_address=x)');
        }
    }

    public function deleteUser(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->deleteUser($body['id_user'] ?? null)) {
            $response->Success('User deleted');
        } else {
            $response->Error('Not allowed to delete this user or user not found');
        }
    }

    public function getAddress(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->user_model->getAddress($body['id_user'] ?? null, $body['id_address'] ?? null);
        if (empty($data) || !is_array($data) || !$data) { 
            $response->Error('Address not found or not allowed to see this address');
        } else {
            $response->Success($data);
        }
    }

    public function getCard(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->user_model->getCard($body['id_user'] ?? null, $body['id_card'] ?? null);
        if (empty($data) || !is_array($data) || !$data) { 
            $response->Error('Card not found or not allowed to see this card');
        } else {
            $response->Success($data);
        }
    }

}
?>