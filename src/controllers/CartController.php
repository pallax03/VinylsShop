<?php
class CartController extends Controller {

    private $auth_model = null;
    private $user_model = null;
    private $cart_model = null;
    private $order_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'UserModel.php';
        $this->user_model = new UserModel();

        require_once MODELS . 'CartModel.php';
        $this->cart_model = new CartModel();

        require_once MODELS . 'OrderModel.php';
        $this->order_model = new OrderModel();
    }

    public function index(Request $request, Response $response) {
        $this->redirectSuperUser();

        $head = array('title' => 'Cart', 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');
        
        $data['user'] = $this->user_model->getUser(Session::getUser());
        $data['cart'] = $this->cart_model->getCart();
        $data['total'] = Session::getTotal();

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

    public function get(Request $request, Response $response) {
        $response->Success(['cart' => $this->cart_model->getCart(), 'total' => Session::getTotal()]);
    }

    public function sync(Request $request, Response $response) {
        if($this->cart_model->syncCart()) {
            $response->Success('Cart synced');
        } else {
            $response->Error('Cart not synced');
        }
    }

    public function checkout(Request $request, Response $response) {
        $this->redirectUser();
        $this->redirectIf(empty($this->cart_model->getCart()), '/cart');

        $head = array('title' => 'Checkout', 'style'=> array(''));
        $this->render('checkout', $head);
    }

    public function pay(Request $request, Response $response) {
        $this->redirectUser();
        $this->redirectIf(empty(Session::getCart()), '/cart');
        
        $body = $request->getBody();

        if($this->order_model->setOrder($body['discount_code'] ?? null)) {
            $this->cart_model->purgeUserCart();
            $this->cart_model->syncCart();
            $response->Success('Order placed');
        } else {
            $response->Error('Order cannot be placed');
        }

    }

}
?>