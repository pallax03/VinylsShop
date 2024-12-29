<?php
final class CartModel {

    private $vinyls_model = null;

    public function __construct() {
        require_once MODELS . 'VinylsModel.php';
        $this->vinyls_model = new VinylsModel();

        $this->syncCart();
    }


    /**
     * Get the cart of a specific user or the logged user.
     * a super user can get any user's cart
     * 
     * @param [int|null] $id_user if null, the logged user
     * @return [array|bool] the cart of the user, false if query failed.
     */
    public function getUserCart($id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return [];
        }

        // get the cart from the database.
        return Database::getInstance()->executeResults(
            "SELECT c.id_vinyl, c.quantity
                FROM carts c
                WHERE c.id_user = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }

    /**
     * Update the cart of a specific user or the logged user.
     * a super user can update any user's cart
     * if the quantity is <= 0, the vinyl will be removed from the cart.
     *
     * @param [int|null] $id_user, if null, the logged user
     * @return [bool] true if the cart is updated, false otherwise.
     */
    public function setUserCart($id_vinyl, $quantity, $id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return false;
        }
        
        if ($quantity <= 0) {
            return $this->removeUserCart($id_vinyl, $id_user);
        }

        // if the vinyl is already in the cart, update the quantity.
        if(!empty(Database::getInstance()->executeResults(
                "SELECT * FROM carts
                    WHERE id_user = ? AND id_vinyl = ?",
                'ii',
                $id_user ?? Session::getUser(),
                $id_vinyl))
        ) {
            return Database::getInstance()->executeQueryAffectRows(
                "UPDATE carts
                    SET quantity = ?
                    WHERE id_user = ? AND id_vinyl = ?",
                'iii',
                $quantity,
                $id_user ?? Session::getUser(),
                $id_vinyl
            );
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO carts (id_user, id_vinyl, quantity)
                VALUES (?, ?, ?)",
            'iii',
            $id_user ?? Session::getUser(),
            $id_vinyl,
            $quantity
        );
    }

    /**
     * Remove a vinyl from the cart of a specific user or the logged user.
     * a super user can remove any user's vinyl from the cart.
     *
     * @param [int|null] $id_user, if null, the logged user
     * @return [bool] true if the vinyl is removed, false otherwise.
     */
    public function removeUserCart($id_vinyl, $id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM carts
                WHERE id_user = ? AND id_vinyl = ?",
            'ii',
            $id_user ?? Session::getUser(),
            $id_vinyl
        );
    }

    /**
     * Get the cart of the user.
     * sync the session cart with the database.
     * of the logged user.
     *
     * @param int $id_user
     * @return array the cart of the user.
     */
    public function getCart() {
        if (Session::isLogged()) {
            $this->syncCart();
        }
        return Session::getCart();;
    }

    /**
     * Set the cart of the user.
     * store in session, and try to sync.
     *
     * @param int $id_vinyl
     * @param int $quantity
     * @return bool true if the cart is set, false otherwise.
     */
    public function setCart($id_vinyl, $quantity) {
        // maybe check if the vinyl exists and can be shopped.
        if (!($id_vinyl && $quantity)) {
            return false;
        }
        Session::setToCart($this->vinyls_model->getVinyl($id_vinyl), $quantity);
        
        //need to sync after the set? (90% yes)
        // $this->syncCart();
        return true;
    } 

    /**
     * Load the cart of the user, into Session from DB.
     *
     * @return bool true if the cart is loaded, false otherwise.
     */
    private function loadCart() {
        if (!Session::isLogged()) {
            return false;
        }
        foreach ($this->getUserCart() as $key => $vinyl) {
            // DB is prior in sync so if a duplicate in session session will be removed.
            if (Session::getVinylFromCart($vinyl['id_vinyl'])) {
                Session::removeVinylFromCart($vinyl['id_vinyl']);
            }
            Session::setToCart($this->vinyls_model->getVinyl($vinyl['id_vinyl']), $vinyl['quantity']);
        }
        return true;
    }

    /**
     * Check if the vinyls are still available.
     * 
     * @param int $id_vinyl the id of the vinyl.
     *
     * @return bool true if the vinyl is still available, false otherwise.
     */
    private function checkVinyl($id_vinyl, $wanted_quantity) {
        $quantity = $this->vinyls_model->getVinyl($id_vinyl)['quantity'];
        return  $quantity - $wanted_quantity > 0 ? $wanted_quantity : $quantity;
    }

    /**
     * sync the session cart with the database.
     * Checking:
     * - if the vinyl is still available.
     * - if the vinyl is still in the cart.
     *
     * @return bool true if the cart is synced, false otherwise.
     */
    private function syncAndCheckCart() {
        foreach (Session::getCart() as $item) {
            $this->setUserCart($item['vinyl']['id_vinyl'], $this->checkVinyl($item['vinyl']['id_vinyl'], $item['quantity']));
        }
        $this->loadCart();
        return true;
    }
    

    /**
     * Sync the session cart with the database.
     * Checking:
     * - if the user is logged.
     * - if the vinyl is still available.
     * - if the vinyl is still in the cart.
     *
     * @return bool true if the cart is synced, false otherwise.
     */
    public function syncCart() {
        if (!Session::isLogged()) {
            return false;
        }
        $this->loadCart();
        $this->syncAndCheckCart();
        return Session::getCart();
    }

    /**
     * Get the total of the session cart.
     *
     * @return int the total of the cart.
     */
    public function getTotal() {
        // return array_reduce(Session::get('Cart'), fn($total, $vinyl) => $total + $vinyl['price'] * $vinyl['quantity'], 0);
        $cart = Session::getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['vinyl']['cost'] * $item['quantity'];
        }
        return $total;
    }

}
