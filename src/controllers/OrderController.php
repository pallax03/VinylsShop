<?php
class OrderController extends Controller {

    private $auth_model = null;
    private $order_model= null;
    private $vinyls_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'OrderModel.php';
        $this->order_model = new OrderModel();

        require_once MODELS . 'VinylsModel.php';
        $this->vinyls_model = new VinylsModel();
    }

    
    public function index(Request $request, Response $response) {
        $this->redirectSuperUser();
        $this->auth_model->checkAuth();

        $body = $request->getBody();
        $title = $data['title'] ?? 'Order Info';
        $head = array('title' => $title, 'style'=> array(''),
         'header' => '');

        $data['order'] = $this->order_model->getOrder($body['id_order'] ?? null);

        $this->render('order', $head, $data);
    }

    public function getOrders(Request $request, Response $response) {
        $this->auth_model->checkAuth();
        $body = $request->getBody();
        
        $data = $this->order_model->getOrders($body['id_user'] ?? null);
        if (empty($data) || !is_array($data) || !$data) { 
            $response->Error('User not found or not allowed to see those orders ' , $body);
        } else {
            $response->Success($data);
        }
    }

}
?>