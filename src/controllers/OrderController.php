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

    /**
     * Get all orders, an admin can get any user orders
     * A user can only get his own orders
     *
     * @return json
     */
    public function getOrders(Request $request, Response $response) {
        $body = $request->getBody();
        
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('You are not allowed to see those orders', $body);
            return;
        }
        $data = $this->order_model->getOrders($body['id_user'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('User not found' , $body);
    }

    /**
     * Get a single order, a user can only get his own orders
     * An admin can get any order
     *
     * @return json
     */
    public function getOrder(Request $request, Response $response) {
        $body = $request->getBody();
        if (!Session::haveAdminUserRights($body['id_user'] ?? null)) {
            $response->Error('You are not allowed to see this order', $body);
            return;
        }
        $data = $this->order_model->getOrder($body['id_order'] ?? null, $body['id_user'] ?? null);
        if (!empty($data)) { 
            $response->Success($data);
            return;
        }
        $response->Error('Order not found' , $body);

    }

    /**
     * Add an order, only a user can add an order
     *
     * @return json
     */
    public function setShipping(Request $request, Response $response) {
        $body = $request->getBody(); 
        if(!Session::isSuperUser()) {
            $response->Error('You are not allowed to update shipping info');
            return;
        }
        if($body['shipping_courier'] && $body['shipping_cost'] && $body['shipping_goal']) {
            LoadEnv::set('SHIPPING_COURIER', $body['shipping_courier']);
            LoadEnv::set('SHIPPING_COST', $body['shipping_cost']);
            LoadEnv::set('SHIPPING_GOAL', $body['shipping_goal']);
            $response->Success('Shipping info updated');
            return;
        }
        $response->Error('Shipping info not correct', $body);
    }

    public function getCoupons(Request $request, Response $response) {
        $body = $request->getBody();
        $result = $this->order_model->getCoupons($body['id_coupon'] ?? null);
        if (!empty($result)) {
            $response->Success($result);
            return;
        }
        
        $response->Error('No coupons found');
    }

    public function setCoupon(Request $request, Response $response) {
        $body = $request->getBody();
        if(!Session::isSuperUser()) {
            $response->Error('You are not allowed to add a coupon');
            return;
        }
        if($body['discount_code'] && $body['percentage'] && $body['valid_from'] && $body['valid_until']) {
            if($this->order_model->setCoupon($body['discount_code'], $body['percentage'], $body['valid_from'], $body['valid_until'], $body['id_coupon'] ?? null)) {
                $response->Success('Coupon added / updated');
                return;
            }
        }
        $response->Error('Coupon not added', $body);
    }

    public function deleteCoupon(Request $request, Response $response) {
        $body = $request->getBody();
        if(!Session::isSuperUser()) {
            $response->Error('You are not allowed to delete a coupon');
            return;
        }
        if($body['id_coupon']) {
            if($this->order_model->deleteCoupon($body['id_coupon'])) {
                $response->Success('Coupon deleted');
                return;
            }
        }
        $response->Error('Coupon not deleted', $body);
    }
}
?>