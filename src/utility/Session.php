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
        return self::isSet('User');
    }


    public static function getUser() {
        if (!self::isLogged() || !isset(self::get('User')['id_user'])) {
            return false;
        }
        return self::get('User')['id_user'];
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

}