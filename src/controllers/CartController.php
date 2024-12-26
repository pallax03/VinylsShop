<?php
class CartController extends Controller {

    private $auth_model = null;
    private $user_model = null;
    private $vinyls_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'UserModel.php';
        $this->user_model = new UserModel();

        require_once MODELS . 'VinylsModel.php';
        $this->vinyls_model = new VinylsModel();
    }

    public function index(Request $request, Response $response) {
        $this->redirectSuperUser();

        $head = array('title' => 'Cart', 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');
        
        $data = $this->user_model->getUser(Session::getUser()) ?? [];
        $this->render('cart', $head, $data);
    }

    public function checkout(Request $request, Response $response) {
        $this->redirectUser();

        $head = array('title' => 'Checkout', 'style'=> array(''));
        $this->render('checkout', $head);
    }

    // public function manage(Request $request, Response $response) {
    //     $data = $request->getBody();
    //     $cart = Session::getCart();
    //     $cart[$data['id']] = $data['quantity'];
    //     Session::setCart($cart);
    //     $response->redirect('/cart');
    // }


}
?>