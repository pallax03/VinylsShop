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
         'header' => '');
        
        $data['user'] = $this->user_model->getUser();
        $data['orders'] = $this->order_model->getOrders();
        $this->render('user', $head, $data);
    }

    public function addresses() {
        $this->auth_model->checkAuth();
        $head = array('title' => 'Addresses', 'style'=> array(''),
         'header' => '');
        
        $data['user'] = $this->user_model->getUser();
        $data['addresses'] = $this->user_model->getAddress();
        $this->render('addresses', $head, $data);
    }

    public function cards() {
        $this->auth_model->checkAuth();
        $head = array('title' => 'Cards', 'style'=> array(''),
         'header' => '');
        
        $data['user'] = $this->user_model->getUser();
        $data['cards'] = $this->user_model->getCard();
        $this->render('cards', $head, $data);
    }

    public function getUser(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->user_model->getUser($body['id_user'] ?? null);
        if (empty($data) || !is_array($data) || !$data) { 
            $response->Error('User not found or not allowed to see this user ' , $body);
        } else {
            $response->Success($data);
        }
    }

    public function setUserDefaults(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->setDefaults($body['id_card'] ?? null, $body['id_address'] ?? null)) {
            $response->Success('Defaults set', $body);
        } else {
            $response->Error('Not allowed to set defaults or card/address not found', $body);
        }
    }

    public function deleteUser(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->deleteUser($body['id_user'] ?? null)) {
            $response->Success('User deleted', $body);
        } else {
            $response->Error('Not allowed to delete this user or user not found', $body);
        }
    }

    public function getAddress(Request $request, Response $response) {
        $body = $request->getBody();

        $data = $this->user_model->getAddress($body['id_user'] ?? null, $body['id_address'] ?? null);
        if (empty($data) || !is_array($data) || !$data) { 
            $response->Error('Address not found or not allowed to see this address', $body);
        } else {
            $response->Success($data);
        }
    }

    public function setAddress(Request $request, Response $response) {
        $body = $request->getBody();
        $this->user_model->setAddress($body['address_name'] ?? null, $body['address_street'] ?? null, $body['address_city'] ?? null, $body['address_cap'] ?? null);
        $response->redirect('/user/addresses');
    }

    public function deleteAddress(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->deleteAddress($body['id_address'] ?? null, $body['id_user'] ?? null)) {
            $response->Success('Address deleted', $body);
        } else {
            $response->Error('Not allowed to delete this address or address not found', $body);
        }
    }
    
    public function getCard(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->user_model->getCard($body['id_user'] ?? null, $body['id_card'] ?? null);
        if (empty($data) || !is_array($data) || !$data) { 
            $response->Error('Card not found or not allowed to see this card', $body);
        } else {
            $response->Success($data);
        }
    }

    public function setCard(Request $request, Response $response) {
        $body = $request->getBody();
        $this->user_model->setCard($body['card_number'] ?? null, $body['card_exp'] ?? null, $body['card_cvc'] ?? null);
        $response->redirect('/user/cards');
    }

    public function deleteCard(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->deleteCard($body['id_card'] ?? null, $body['id_user'] ?? null)) {
            $response->Success('Card deleted', $body);
        } else {
            $response->Error('Not allowed to delete this card or card not found', $body);
        }
    }

}
?>