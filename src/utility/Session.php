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

    public static function getCard() {
        return self::isSet('Card') ? self::get('Card') : false;
    }

    public static function setToCart($vinyl, $quantity) {
        if (!self::isSet('Cart')) {
            self::set('Cart', []);
        }
        $cart = self::get('Cart');
        $cart[$vinyl] = $quantity;
        self::set('Cart', $cart);
    }
}