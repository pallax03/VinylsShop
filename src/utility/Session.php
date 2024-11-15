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
    
    public static function isUser() {
        return self::isSet('User');
    }
    
    public static function isLogged() {
        return self::isSet('User');
    }
    
    public static function isAdmin() {
        return self::isSet('User') && self::get('User')['su'];
    }
    
    public static function isNotLogged() {
        return !self::isSet('User');
    }
    
    public static function isNotAdmin() {
        return !self::isSet('User') || !self::get('User')['su'];
    }
    
    public static function isNotSuperUser() {
        return !self::isSet('User') || !self::get('User')['su'];
    }
    
    public static function isNotUser() {
        return !self::isSet('User');
    }
    
    public static function isNot($key) {
        return !self::isSet($key);
    }
    
    public static function is($key) {
        return self::isSet($key);
    }
    
    public static function isNotSet($key) {
        return !self::isSet($key);
    }
}