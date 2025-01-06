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
        
        if (Session::isLogged()) {
            $data['user'] = $this->user_model->getUser();
            $data['orders'] = $this->order_model->getOrders();
            $this->render('user/user', $head, $data);
            return;
        }
        
        $this->render('user/user', $head);
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

    /**
     * Get all users, only for superusers ⭐️
     *
     * @return json
     */
    public function getUsers(Request $request, Response $response) {
        if(!Session::isSuperUser()) {
            $response->Error('not allowed to see all users');
            return;
        }
        
        $data = $this->user_model->getUsers();
        $response->Success($data);
    }

    /**
     * Get a single user, a super user can get any user
     * Cannot get a user if: the user is not logged.
     *
     * @return json
     */
    public function getUser(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to see this user', $body);
            return;
        }
        
        $data = $this->user_model->getUser($body['id_user'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('User not found', $body);
    }

    /**
     * Set the defaults for a user, like the default card and address.
     * a super user can set the defaults for any user, but a user can only set his defaults.
     *
     * @return json
     */
    public function setUserDefaults(Request $request, Response $response) {
        $body = $request->getBody();

        if(!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to set defaults', $body);
            return;
        }

        if ($this->user_model->setDefaults($body['id_user'] ?? null, $body['id_card'] ?? null, $body['id_address'] ?? null)) {
            $response->Success('Defaults set');
            return;
        } 
        $response->Debug('Error', $body);
    }

    /**
     * Update a user, a super user can update any user, and his balance.
     * A user can update only himself, but not is balance.
     *
     * @return json
     */
    public function updateUser(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null) || ($body['balance'] && Session::isSuperUser())) {
            $response->Error('Not allowed to update this user', $body);
            return;
        }

        if($this->user_model->updateUser($body['id_user'] ?? null, $body['user_name'] ?? null, $body['newsletter'] ?? null, $body['balance'] ?? null)) {
            $response->Success('User updated');
            return;
        }
        $response->Debug('Error', $body);
    }

    /**
     * delete a user, a super user can delete any user except himself.
     * A user can delete only himself.
     *
     * @return json
     */
    public function deleteUser(Request $request, Response $response) {
        $body = $request->getBody();
        $id_user = $body['id_user'] ?? null;
        if (Session::isSuperUser() ? Session::isHim($id_user) : !Session::isHim($id_user)) {
            $response->Error('Not allowed to delete this user', $body);
            return;
        }

        if($id_user) {
            if ($this->user_model->deleteUser($id_user)) {
                $response->Success('User deleted');
                return;
            }
        }
        $response->Error('User not deleted', $body);
    }


    /**
     * Get all addresses, a super user can get any address.
     * A user can get only his addresses.
     *
     * @return json
     */
    public function getAddress(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to see those address', $body);
            return;
        }

        $data = $this->user_model->getAddress($body['id_user'] ?? null, $body['id_address'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('Address not found', $body);
    }


    /**
     * Set an address, a super user can set any address.
     * A user can set only his addresses.
     *
     * @return json
     */
    public function setAddress(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to set this address', $body);
            return;
        }
        if($body['address_name'] && $body['address_street'] && $body['address_city'] && $body['address_cap']) {
            if($this->user_model->setAddress($body['address_name'], $body['address_street'], $body['address_city'], $body['address_cap'], $body['id_user'] ?? null)) {
                $response->Success('Address added');
                return;
            }
        }
        $response->Error('Address not added', $body);
    }

    /**
     * Update an address, a super user can update any address.
     * A user can update only his addresses.
     *
     * @return json
     */
    public function deleteAddress(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to delete this address', $body);
            return;
        }
        if($body['id_address']) {
            if ($this->user_model->deleteAddress($body['id_address'], $body['id_user'] ?? null)) {
                $response->Success('Address deleted');
                return;
            }
        }
        $response->Error('Address not deleted', $body);
    }
    
    /**
     * Get all cards, a super user can get any card.
     * A user can get only his cards.
     *
     * @return json
     */
    public function getCard(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to see those cards', $body);
            return;
        }
        $data = $this->user_model->getCard($body['id_user'] ?? null, $body['id_card'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('Card not found', $body);
    }

    /**
     * Set a card, a super user can set any card.
     * A user can set only his cards.
     *
     * @return json
     */
    public function setCard(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to set this card', $body);
            return;
        }
        if($body['card_number'] && $body['card_exp'] && $body['card_cvc']) {
            if($this->user_model->setCard($body['card_number'], $body['card_exp'], $body['card_cvc'], $body['id_user'] ?? null)) {
                $response->Success('Card added');
                return;
            }
        }
        $response->Error('Card not added', $body);
    }

    /**
     * Delete a card, a super user can delete any card.
     * A user can delete only his cards.
     *
     * @return json
     */
    public function deleteCard(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('Not allowed to delete this card', $body);
            return;
        }
        if($body['id_card']) {
            if ($this->user_model->deleteCard($body['id_card'], $body['id_user'] ?? null)) {
                $response->Success('Card deleted');
                return;
            }
        }
        $response->Error('Card not deleted', $body);
    }
}
?>