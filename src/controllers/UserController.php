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
        $this->redirectSuperUser();
        $head = array('title' => Session::isLogged() ? 'User' : 'Login / Signup',
         'style'=> array(''),
         'header' => "Oltre i " . $_ENV['SHIPPING_GOAL'] . "€ spedizione gratuita!");
        
        $data['user'] = $this->user_model->getUser();
        $data['orders'] = $this->order_model->getOrders();
        $this->render('user/user', $head, $data);
    }

    public function addresses() {
        $this->redirectSuperUser();
        $this->auth_model->checkAuth();
        $head = array('title' => 'Addresses');
        
        $data['user'] = $this->user_model->getUser();
        $data['addresses'] = $this->user_model->getAddress();
        $this->render('user/addresses', $head, $data);
    }

    public function cards() {
        $this->redirectSuperUser();
        $this->auth_model->checkAuth();
        $head = array('title' => 'Cards');
        
        $data['user'] = $this->user_model->getUser();
        $data['cards'] = $this->user_model->getCard();
        $this->render('user/cards', $head, $data);
    }

    public function getUsers(Request $request, Response $response) {
        $data = $this->user_model->getUsers();
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('not allowed to see all users');
    }

    public function getUser(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->user_model->getUser($body['id_user'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('User not found or not allowed to see this user ', $body);
    }

    public function setUserDefaults(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->setDefaults($body['id_card'] ?? null, $body['id_address'] ?? null)) {
            $response->Success('Defaults set', $body);
            return;
        } 
        $response->Error('Not allowed to set defaults or card/address not found', $body);
    }

    public function updateUser(Request $request, Response $response) {
        $body = $request->getBody();
        $this->user_model->updateUser($body['id_user'] ?? null, $body['user_name'] ?? null, $body['newsletter'] ?? null, $body['balance'] ?? null);
        $response->redirect('/user');
    }

    public function deleteUser(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->user_model->deleteUser($body['id_user'] ?? null)) {
            $response->Success('User deleted', $body);
            return;
        }
        $response->Error('Not allowed to delete this user or user not found', $body);
    }

    public function getAddress(Request $request, Response $response) {
        $body = $request->getBody();

        $data = $this->user_model->getAddress($body['id_user'] ?? null, $body['id_address'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('Address not found or not allowed to see this address', $body);
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
            return;
        }
        $response->Error('Not allowed to delete this address or address not found', $body);
    }
    
    public function getCard(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->user_model->getCard($body['id_user'] ?? null, $body['id_card'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('Card not found or not allowed to see this card', $body);
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
            return;
        }
        $response->Error('Not allowed to delete this card or card not found', $body);
    }
}
?>