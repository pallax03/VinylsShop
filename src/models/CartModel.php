<?php
final class CartModel {

    private $vinyls_model = null;

    public function __construct() {
        require_once MODELS . 'VinylsModel.php';
        $this->vinyls_model = new VinylsModel();

        $this->loadCart();
        $this->syncCart();
    }


    /**
     * Get the cart of a specific user or the logged user.
     * a super user can get any user's cart
     * 
     * @param int|null $id_user if null, the logged user
     * @return array the cart of the user, false if query failed.
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
     * Delete the cart of a specific user or the logged user.
     *
     * @param int|null $id_user if null, the logged user
     * @return bool true if the cart is purged, false otherwise.
     */
    public function purgeUserCart($id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM carts
                WHERE id_user = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }


    /**
     * Update the cart of a specific user or the logged user.
     * a super user can update any user's cart
     * if the quantity is <= 0, the vinyl will be removed from the cart.
     *
     * @param int $id_vinyl
     * @param int $quantity
     * @param int|null $id_user, if null, the logged user
     * 
     * @return bool true if the cart is updated, false otherwise.
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
     * @param int $id_vinyl
     * @param int|null $id_user, if null, the logged user
     * 
     * @return bool true if the vinyl is removed, false otherwise.
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
     * Get the cart of the logged user.
     * sync the session cart with the database.
     *
     * @return array the cart of the user.
     */
    public function getCart() {
        $this->syncCart();
        return Session::getCart();
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
        
        // Check if the vinyl is still available.
        $old_quantity = Session::getVinylFromCart($id_vinyl)['quantity'];
        if(isset($old_quantity)) {
            $quantity = $old_quantity + $quantity;
            Session::setToCart($this->vinyls_model->getVinyl($id_vinyl), $this->checkVinyl($id_vinyl, $quantity));
        } else {
            Session::addToCart($this->vinyls_model->getVinyl($id_vinyl), $quantity);    
        }
        
        // if the vinyl was removed sync in DB, because now Session has prio than DB.
        foreach ($this->getUserCart() as $vinyl) { // if is not logged it iterate over [].
            if (empty(Session::getVinylFromCart($vinyl['id_vinyl']))) {
                $this->setUserCart($id_vinyl, 0);
            }
        }

        // sync the cart in the DB.
        $this->syncCart();
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
     * Check if the wanted quantity is available for the vinyl.
     * 
     * @param int $id_vinyl the id of the vinyl.
     * @param int $wanted_quantity the quantity wanted.
     *
     * @return int the minimum quantity of the vinyl available.
     */
    private function checkVinyl($id_vinyl, $wanted_quantity) {
        $quantity = $this->vinyls_model->getVinyl($id_vinyl)['quantity'];
        return  $quantity - $wanted_quantity > 0 ? $wanted_quantity : $quantity;
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
        
        // it will sync the cart in the DB, checking if the vinyl is still available.
        foreach (Session::getCart() as $item) {
            $this->setUserCart($item['vinyl']['id_vinyl'], $this->checkVinyl($item['vinyl']['id_vinyl'], $item['quantity']));
        }
        $this->loadCart();
        return true;
    }
}
