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
        $head = array('title' => $title);

        $data['order'] = $this->order_model->getOrder($body['id_order'] ?? null);

        $this->render('ecommerce/order', $head, $data);
    }

    public function getOrders(Request $request, Response $response) {
        $this->auth_model->checkAuth();
        $body = $request->getBody();
        
        $data = $this->order_model->getOrders($body['id_user'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('User not found or not allowed to see those orders ' , $body);
    }

    public function updateShipping(Request $request, Response $response) {
        $body = $request->getBody(); 
        if(Session::isSuperUser() && $body['shipping_courier'] && $body['shipping_cost'] && $body['shipping_goal']) {
            LoadEnv::set('SHIPPING_COURIER', $body['shipping_courier']);
            LoadEnv::set('SHIPPING_COST', $body['shipping_cost']);
            LoadEnv::set('SHIPPING_GOAL', $body['shipping_goal']);
            $response->Success('Shipping info updated');
            return;
        }
        $response->Error('You are not allowed to set the shipping info, or the data is not correct', $body);
    }

    public function getCoupons(Request $request, Response $response) {
        $body = $request->getBody();
        $response->Success($this->order_model->getCoupons($body['id_coupon'] ?? null), $body);
    }

    public function setCoupon(Request $request, Response $response) {
        $body = $request->getBody();
        if(Session::isSuperUser() && $body['discount_code'] && $body['percentage'] && $body['valid_from'] && $body['valid_until']) {
            if($this->order_model->setCoupon($body['discount_code'], $body['percentage'], $body['valid_from'], $body['valid_until'], $body['id_coupon'] ?? null)) {
                $response->Success('Coupon added / updated');
                return;
            }
        } else {
            $response->Error('You are not allowed to add a coupon, or the data is not correct');
            return;
        }
        $response->Debug('Error', $body);
    }

    public function deleteCoupon(Request $request, Response $response) {
        $body = $request->getBody();
        if(Session::isSuperUser() && $body['id_coupon']) {
            if($this->order_model->deleteCoupon($body['id_coupon'])) {
                $response->Success('Coupon deleted');
                return;
            }
        } else {
            $response->Error('You are not allowed to delete a coupon, or the data is not correct');
            return;
        }
        $response->Debug('Error', $body);
    }
}
?>