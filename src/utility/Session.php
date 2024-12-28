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
     * @param int $id_user
     * @return bool
     */
    public static function isHim($id_user = null) {
        return $id_user ? self::getUser() == $id_user : self::isLogged();
    }


    /**
     * A super user can update any user, and himself.
     * A user can update only himself.
     *
     * @param [int] $id_user if null, it will check if the user is logged.
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
        return self::isSet('Card') ? self::get('Card') : self::set('Card', []);
    }

    /**
     * Remove a vinyl from the cart.
     *
     * @param [int] $id_vinyl the id of the vinyl to remove.
     * @return array it return getCart
     */
    public static function removeFromCart($id_vinyl) {
        self::set('Card', array_values(array_filter(self::getCart(), fn($vinyl) => $vinyl['vinyl']['id_vinyl'] != $id_vinyl)));
        return self::getCart();
    }

    /**
     * Set the cart of the user, quantity can be negative.
     * Checking:
     * - if the vinyl is already present.
     * - if the quantity of a present vinyl go to 0, it will be removed.
     * 
     * @param [array] $vinyl the vinyl to add to the cart.
     * @param [int | null] $quantity, if null, it will be set to 1.
     * @return array it return getCart
     */
    public static function setToCart($vinyl, $quantity = null) {
        // self::set('Card', array_merge(self::getCart(), [['vinyl' => $vinyl, 'quantity' => $quantity ?? 1]]));
        

        return self::getCart();
    }
}