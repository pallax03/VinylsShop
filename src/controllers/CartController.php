<?php
class CartController extends Controller {

    private $auth_model = null;
    private $user_model = null;
    private $cart_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'UserModel.php';
        $this->user_model = new UserModel();

        require_once MODELS . 'CartModel.php';
        $this->cart_model = new CartModel();
    }

    public function index(Request $request, Response $response) {
        $this->redirectSuperUser();

        $head = array('title' => 'Cart', 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');
        
        $data['user'] = $this->user_model->getUser(Session::getUser());
        $data['cart'] = $this->cart_model->getCart();
        $this->render('cart', $head, $data);
    }

    public function manage(Request $request, Response $response) {
        $body = $request->getBody();
        
        if ($this->cart_model->setCart($body['id_vinyl'], $body['quantity'])) {
            $response->Success('Cart updated', $body);
        } else {
            $response->Error('Cart not updated', $body);
        }
    }

    public function checkout(Request $request, Response $response) {
        $this->redirectUser();

        $head = array('title' => 'Checkout', 'style'=> array(''));
        $this->render('checkout', $head);
    }

}
?>