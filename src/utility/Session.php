<?php
class Session {
    public static function start() {
        session_start();
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key) {
        return $_SESSION[$key];
    }
    
    public static function destroy() {
        session_destroy();
    }
    
    public static function isSet($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function unset($key) {
        unset($_SESSION[$key]);
    }
    

    public static function isSuperUser() {
        return self::isLogged() && self::get('User')['su'];
    }
    

    public static function isLogged() {
        return self::isSet('User') && isset(self::get('User')['id_user']);
    }


    public static function getUser() {
        return self::isLogged() ? self::get('User')['id_user'] : false;
    }

    /**
     * This function checks overall if the user isLogged, then
     * if the id_user is the same as the logged user.
     * @param int|null $id_user if null, it will check if the user is logged.
     * @return bool
     */
    public static function isHim($id_user = null) {
        return $id_user ? self::getUser() == $id_user : self::isLogged();
    }


    /**
     * A super user can update any user, and himself.
     * A user can update only himself.
     *
     * @param int|null $id_user if null, it will check if the user is logged.
     * @return bool 
     */
    public static function haveAdminUserRights($id_user = null) {
        return Session::isSuperUser() || Session::isHim($id_user);
    }

    /**
     * get the cart of the logged user.
     *
     * @return array the vinyl into the cart.
     */
    public static function getCart() {
        if(!self::isSet('Cart')) {
            self::set('Cart', []);
        }
        return self::get('Cart');
    }

    /**
     * Set the cart of the user, quantity can be negative.
     * Checking:
     * - if the vinyl is already present.
     * - if the quantity of a present vinyl go to 0, it will be removed.
     * 
     * @param array $vinyl the vinyl to add to the cart.
     * @param int|null $quantity, if null, it will be set to 1.
     * @return array it return getCart
     */
    public static function setToCart($vinyl, $quantity = 1) { 
        if (empty($vinyl) || !isset($vinyl['id_vinyl']) ) {
            return self::getCart();
        }

        // take the vinyls from the cart, and do the operation.
        // after all, re-set the cart.
        $cart = self::getCart();
        $found = false;
        foreach ($cart as $key => $item) { // if the vinyl is found, update his quantity.
            if ($item['vinyl']['id_vinyl'] === $vinyl['id_vinyl']) {
                $found = true;
                $cart[$key]['quantity'] = $quantity;
                if ($cart[$key]['quantity'] <= 0) {  // if the quantity is 0 or negative, remove the vinyl from the cart.
                    unset($cart[$key]); 
                }
                break;
            }
        }
        
        if (!$found && $quantity > 0) { // if the vinyl is not found, and the quantity is positive, add it.
            array_push($cart, ['vinyl' => $vinyl, 'quantity' => $quantity]);
        }

        self::set('Cart', $cart);
        return self::getCart();
    }

    public static function getVinylFromCart($id_vinyl) {
        foreach (self::getCart() as $item) {
            if ($item['vinyl']['id_vinyl'] === $id_vinyl) {
                return $item;
            }
        }
    }

    /**
     * Remove the vinyl from the cart.
     *
     * @param int $id_vinyl
     * @return void
     */
    public static function removeVinylFromCart($id_vinyl) {
        $cart = self::getCart();
        $cart = array_filter($cart, function($item) use ($id_vinyl) {
            return $item['vinyl']['id_vinyl'] !== $id_vinyl;
        });
        self::set('Cart', array_values($cart)); // Re-index the array
    }

    /**
     * Add a vinyl to the cart.
     *
     * @param array $vinyl
     * @param int|null $quantity, if null, it will be set to 1.
     * @return array the cart.
     */
    public static function addToCart($vinyl, $quantity = 1) {
        $old_quantity = self::getVinylFromCart($vinyl['id_vinyl']);
        return self::setToCart($vinyl, isset($old_quantity['quantity']) ? $old_quantity['quantity'] + $quantity : $quantity);
    }

    public static function resetCart() {
        self::set('Cart', []);
    }
}