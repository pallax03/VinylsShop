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
        return self::isSet('User') && self::get('User')['su'];
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

}