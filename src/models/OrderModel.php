<?php
final class OrderModel
{

    private $vinyls_model = null;
    private $auth_model = null;
    private $user_model = null;
    private $notification_model = null;
    private $cart_model = null;

    public function __construct() {
        require_once MODELS . 'VinylsModel.php';
        $this->vinyls_model = new VinylsModel();

        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();

        require_once MODELS . 'UserModel.php';
        $this->user_model = new UserModel();

        require_once MODELS . 'NotificationModel.php';
        $this->notification_model = new NotificationModel();

        require_once MODELS . 'CartModel.php';
        $this->cart_model = new CartModel();

        $this->updateShippings();
    }

    /**
     * Simulate the shipping of the orders.
     * updating the status of the shipping.
     * By default, the status will be updated to:
     * - "Delivered" when is $delivery_date.
     * - "On delivery" the day before $delivery_date.
     * - "In transit" after 1 day.
     *
     * Sending Notifications to the user.
     * 
     * @return void
     */
    private function updateShippings() {
        $shippings = Database::getInstance()->executeResults(
            "SELECT `id_shipment`, `shipment_date`, `delivery_date`, `shipment_status`, `id_order`, `id_address`, `id_user`
                FROM `shipments`;"
        );
        
        foreach ($shippings as $shipping) {
            $shipment_date = new DateTime($shipping['shipment_date']);
            $delivery_date = new DateTime($shipping['delivery_date']);
            $today = new DateTime(date('Y-m-d'));

            if($today > $delivery_date) {
                $status = 'Delivered';
                $progress = 100;
            } else if ($today->diff($delivery_date)->days <= 1) {
                $status = 'On delivery';
                $progress = 90;
            } else if ($today->diff($shipment_date)->days > 1) {
                $status = 'In transit';
                $progress = intval(($today->diff($shipment_date)->days / $delivery_date->diff($shipment_date)->days) * 100);
            } else {
                $status = 'In preparation';
                $progress = intval(($today->diff($shipment_date)->days / $delivery_date->diff($shipment_date)->days) * 100);
            }

            if ($status != $shipping['shipment_status']) {
                Database::getInstance()->executeQueryAffectRows(
                    "UPDATE `vinylsshop`.`shipments` SET `shipment_status` = ?, `shipment_progress` = ? WHERE `id_shipment` = ?;",
                    'ssi',
                    $status,
                    $progress,
                    $shipping['id_shipment']
                );
                $this->notification_model->createNotification($shipping['id_user'], 'Shipping status updated', '/order?id_order=' . $shipping['id_order'] . '&id_user=' . $shipping['id_user']);
            }
        }
    }

    /**
     * Get all orders of a user
     *
     * @param int $id_user, if null, return the logged user
     * @return array of orders
     */
    public function getOrders($id_user = null) {
        $orders = Database::getInstance()->executeResults(
            "SELECT o.id_order,
                    o.order_date,
                    o.total_cost,
                    s.tracking_number,
                    s.shipment_date,
                    s.delivery_date,
                    s.shipment_status,
                    s.shipment_progress,
                    s.courier,
                    s.notes,
                    s.cost AS shipment_cost,
                    ad.name AS address_name,
                    ad.city AS address_city,
                    ad.postal_code AS address_postal_code,
                    ad.street_number AS address_street_number
                FROM `vinylsshop`.`orders` o
                JOIN `vinylsshop`.`shipments` s ON o.id_order = s.id_order
                JOIN `vinylsshop`.`addresses` ad ON s.id_address = ad.id_address
                WHERE o.id_user = ?
                ORDER BY o.id_order DESC;",
            'i',
            $id_user ?? Session::getUser()
        );

        foreach ($orders as $key => $order) {
            $orders[$key]['vinyls'] = Database::getInstance()->executeResults(
                "SELECT 
                        v.id_vinyl,
                        v.cost,
                        a.title,
                        a.cover
                    FROM `vinylsshop`.`checkouts` co
                    JOIN `vinylsshop`.`vinyls` v ON co.id_vinyl = v.id_vinyl
                    JOIN `vinylsshop`.`albums` a ON v.id_album = a.id_album
                    WHERE co.id_order = ?;",
                'i',
                $order['id_order']
            );
        }
        return $orders;
    }

    /**
     * Check if the order belongs to the user
     *
     * @param int $id_order
     * @param int $id_user
     * @return bool 
     */
    public function isOrderOwner($id_order, $id_user = null) {
        return !empty(Database::getInstance()->executeResults(
            "SELECT id_order FROM `vinylsshop`.`orders` WHERE id_order = ? AND id_user = ?;",
            'ii',
            $id_order,
            $id_user ?? Session::getUser()
        ));
    }

    /**
     * Get a specific order by id
     *
     * @param int|null $id_order
     * @param int|null $id_user, if null, return the logged user
     * @return array of order
     */
    public function getOrder($id_order, $id_user=null) {
        $order = Database::getInstance()->executeResults(
            "SELECT o.id_order,
                    o.order_date,
                    o.total_cost,
                    o.id_card,
                    c.card_number,
                    o.discount_code,
                    p.percentage AS discount_percentage,
                    s.tracking_number,
                    s.shipment_date,
                    s.delivery_date,
                    s.shipment_status,
                    s.shipment_progress,
                    s.courier,
                    s.notes,
                    s.cost AS shipment_cost,
                    ad.name AS address_name,
                    ad.city AS address_city,
                    ad.postal_code AS address_postal_code,
                    ad.street_number AS address_street_number
                FROM `vinylsshop`.`orders` o
                JOIN `vinylsshop`.`shipments` s ON o.id_order = s.id_order
                JOIN `vinylsshop`.`addresses` ad ON s.id_address = ad.id_address
                LEFT JOIN `vinylsshop`.`cards` c ON o.id_card = c.id_card
                LEFT JOIN `vinylsshop`.`coupons` p ON o.discount_code = p.discount_code
                WHERE o.id_user = ? AND o.id_order = ?;",
            'ii',
            $id_user ?? Session::getUser(),
            $id_order ?? ''
        );

        if (!empty($order)) {
            $order = $order[0];
            $order['vinyls'] = Database::getInstance()->executeResults(
                "SELECT co.quantity,
                        v.id_vinyl,
                        v.cost,
                        v.type,
                        v.rpm, 
                        v.inch, 
                        a.genre, 
                        a.title, 
                        a.cover, 
                        t.name AS artist_name 	
                    FROM `vinylsshop`.`checkouts` co 
                    JOIN `vinylsshop`.`vinyls` v ON co.id_vinyl = v.id_vinyl
                    JOIN `vinylsshop`.`albums` a ON v.id_album = a.id_album 
                    JOIN `vinylsshop`.`artists` t ON a.id_artist = t.id_artist 
                    WHERE co.id_order = ?;",
                'i',
                $id_order
            );
        }

        return $order;
    }

    /**
     * Set a shipping for an order.
     *
     * @return bool
     */
    public function setShipping($id_order, $notes = null, $id_address=null) {
        if ($id_order === null) {
            return false;
        }

        $id_address = $id_address ?? $this->user_model->getUser()['default_address'];
        Database::getInstance()->setHandler(null);
        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `vinylsshop`.`shipments` (id_order, tracking_number, shipment_date, delivery_date, shipment_status, courier, notes, cost, id_address, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);",
            'issssssdii',
            $id_order,
            bin2hex(random_bytes(6)),
            date('Y-m-d'),
            date('Y-m-d', strtotime('+7 days')),
            'In preparation',
            $_ENV['SHIPPING_COURIER'],
            $notes ?? '',
            $_ENV['SHIPPING_COST'],
            $id_address,
            Session::getUser()
        );
    }

    private function loadOrderCart($id_order, $cart) {
        foreach ($cart as $vinyl) {
            if (!Database::getInstance()->executeQueryAffectRows(
                "INSERT INTO `vinylsshop`.`checkouts` (id_order, id_vinyl, quantity) VALUES (?, ?, ?);",
                'iii',
                $id_order,
                $vinyl['vinyl']['id_vinyl'],
                $vinyl['quantity']
            )) {
                return false;
            }
        }
        return true;
    }

    private function deleteOrderCart($id_order) {
        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `vinylsshop`.`checkouts` WHERE id_order = ?;",
            'i',
            $id_order
        );
    }

    /**
     * Check if a discount code is valid.
     *
     * @param string $discount_code the discount code
     * 
     * @return float percentage of discount or 0 (so u need to multiply the total by this)
     */
    public function checkDiscount($discount_code) {
        $discount = Database::getInstance()->executeResults(
            "SELECT `percentage`
                FROM `coupons`
                WHERE `discount_code` = ?
                AND CURDATE() BETWEEN `valid_from` AND `valid_until`;",
            's',
            $discount_code
        );

        if (!empty($discount)) {
            return $discount[0]['percentage'];
        }

        return 0;
    }

    private function tryPayment($total) {
        $user = $this->user_model->getUser();
        if ($user['default_card'] == null || $user['default_card'] == '') {
            return $user['balance'] >= $total;
        } 
        return true;
    }

    /**
     * Get the total of the order.
     *
     * @return float
     */
    public function getOrderTotal($discount_code = null) {
        $total = Session::getTotal();
        $discount = $this->checkDiscount($discount_code ?? '');
        $total -= $total * $discount;

        return Session::getTotal() <= $_ENV['SHIPPING_GOAL'] ? $total + $_ENV['SHIPPING_COST'] : $total;
    }

    private function deleteOrder($id_order) {
        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `vinylsshop`.`orders` WHERE `id_order` = ?;",
            'i',
            $id_order
        );
    }

    /**
     * Set an order from the cart.
     *
     * @return bool
     */
    public function setOrder($discount_code = null, $notes = null) {
        $cart = Session::getCart();
        
        if (!$this->cart_model->purgeUserCart() || empty($cart)) {
            return false;
        }

        $total = $this->getOrderTotal($discount_code);
        if(!$this->tryPayment($total)) {
            return false;
        }
        

        if (!Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `vinylsshop`.`orders` (order_date, total_cost, id_user, id_card, discount_code) 
                VALUES (?, ?, ?, ?, ?); ",
            'sdiis',
            date('Y-m-d'),
            $total,
            Session::getUser(),
            $this->user_model->getUser()['default_card'] ?? '',
            $discount_code ?? '',
        )) {
            return false;
        }

        $id_order = Database::getInstance()->executeResults("SELECT LAST_INSERT_ID() AS id_order;")[0]['id_order'];
        if(!$this->setShipping($id_order, notes: $notes)) {
            $this->deleteOrder($id_order);
            $this->cart_model->syncCart();
            return false;
        }
        if(!$this->loadOrderCart($id_order, $cart) || !$this->updateVinylsStock($cart)) {
            $this->deleteOrderCart($id_order);
            $this->deleteOrder($id_order);
            $this->cart_model->syncCart();
            return false;
        }

        $this->notification_model->broadcastFor(
            Database::getInstance()->executeResults("SELECT id_user FROM users WHERE su = 1"),
            'New order!',
            '/order?id_order=' . $id_order . '&id_user=' . Session::getUser()
        );

        Session::resetCart();
        return true;
    }

    /**
     * Update the vinyls stock.
     *
     * @return bool
     */
    public function updateVinylsStock($cart) {
        foreach ($cart as $vinyl) {
            if(!$this->vinyls_model->updateVinyl($vinyl['vinyl']['id_vinyl'], stock: $vinyl['vinyl']['stock'] - $vinyl['quantity'])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get all coupons.
     *
     * @return array of coupons
     */
    public function getCoupons($id_coupon = null) {
        if($id_coupon) {
            return Database::getInstance()->executeResults(
                "SELECT `id_coupon`, `discount_code`, `percentage`, `valid_from`, `valid_until`
                    FROM `vinylsshop`.`coupons`
                    WHERE CURDATE() BETWEEN `valid_from` AND `valid_until`
                    AND `id_coupon` = ?;",
                'i',
                $id_coupon
            )[0];
        }
        return Database::getInstance()->executeResults("SELECT `id_coupon`, `discount_code`, `percentage`, `valid_from`, `valid_until` FROM `vinylsshop`.`coupons` WHERE CURDATE() BETWEEN `valid_from` AND `valid_until`;");
    }

    /**
     * Set a coupon.
     *
     * @return bool
     */
    public function addCoupon($discount_code, $percentage, $valid_from, $valid_until, $id_coupon = null) {
        if ($percentage > 0 && $percentage <= 100) {
            $percentage = $percentage / 100;
        } else {
            return false;
        }

        if($id_coupon) {
            return Database::getInstance()->executeQueryAffectRows(
                "UPDATE `vinylsshop`.`coupons` SET `discount_code` = ?, `percentage` = ?, `valid_from` = ?, `valid_until` = ? WHERE `id_coupon` = ?;",
                'ssssi',
                $discount_code,
                $percentage,
                $valid_from,
                $valid_until,
                $id_coupon
            );
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `vinylsshop`.`coupons` (`discount_code`, `percentage`, `valid_from`, `valid_until`) VALUES (?, ?, ?, ?);",
            'ssss',
            $discount_code,
            $percentage,
            $valid_from,
            $valid_until
        );
    }

    /**
     * Delete a coupon, if cannot be deleted, it will be expired.
     *
     * @return bool
     */
    public function deleteCoupon($id_coupon) {
        Database::getInstance()->setHandler(null); // reset the handler to avoid the error
        $result = Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `vinylsshop`.`coupons` WHERE `id_coupon` = ?;",
            'i',
            $id_coupon
        );
    
        if(!$result) {
            $result = Database::getInstance()->executeQueryAffectRows(
                "UPDATE `vinylsshop`.`coupons` SET `valid_until` = CURDATE() - 1 WHERE `id_coupon` = ?;",
                'i',
                $id_coupon
            );
        }
        return $result;
    }
}
