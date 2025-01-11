<?php
final class AuthModel {

    private static $cookieAuthName = 'user_auth';
    private static $cookieAuthTime = 3600;
    

    private function encryptPassword($password) {
        return md5($password);
    }

    private function generateToken($userId, $isSuperUser) {
        $key = $_ENV['JWT_SECRET_KEY'];
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode(['id_user' => $userId, 'isSuperUser' => $isSuperUser, 'exp' => time() + self::$cookieAuthTime]));
        $signature = hash_hmac('sha256', "$header.$payload", $key, true);
        $signature = base64_encode($signature);
        return "$header.$payload.$signature";
    }

    /**
     * Set the user info into the session
     */
    private function refreshSession($userInfo) {
        Session::set('User', ['id_user' => $userInfo['id_user'], 'su' => $userInfo['isSuperUser']]);
    }

    /**
     * verify the token, extracting the user info.
     *
     * @param string $token
     * @return array user info.
     */
    private function verifyToken($token) {
        $key = $_ENV['JWT_SECRET_KEY'];
        list($header, $payload, $signature) = explode('.', $token);

        $validSignature = hash_hmac('sha256', "$header.$payload", $key, true);
        $validSignature = base64_encode($validSignature);

        if ($signature === $validSignature) {
            $userInfo = json_decode(base64_decode($payload), true);
            if ($userInfo['exp'] > time()) {
                $this->refreshSession($userInfo);
                return $userInfo;
            }
        }
        return [];
    }

    private function setCookie($token) {
        setcookie(self::$cookieAuthName, $token, [
            'expires' => time() + self::$cookieAuthTime,  // Scadenza di 1 ora (modificabile)
            'path' => '/',               // Disponibile su tutto il sito
            'secure' => true,            // Solo tramite HTTPS
            'httponly' => true,          // Non accessibile via JavaScript
            'samesite' => 'Strict'       // Anti-CSRF, non invia il cookie da altre origini
        ]);
    }

    private function isValidMail($mail) {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Checks if the cookie is set, if it is, verifies the token and set is session
     *  after it checks if the user not exist in the database, if true logout.
     *
     * @return bool
     */
    public function checkCookie() {
        if (!isset($_COOKIE[self::$cookieAuthName])) {
            return false;
        }
        $this->verifyToken($_COOKIE[self::$cookieAuthName]);
        $this->checkAuth();
        return true;
    }

    /**
     * Check if the user is logged in, if not redirect to the login page
     * If the user is logged in, fetch the user from the database
     * If the user is not in the database, logout
     *
     * @return void
     */
    public function checkAuth() {
        if (!$this->fetchUser()) {
            $this->logout();
            header('Location: /user');
        }
    }

    /**
     * Fetch the user from the database
     * 
     * @return array the user fetched from the database
     */
    public function fetchUser() {
        return Database::getInstance()->executeResults(
            "SELECT * FROM `users` WHERE id_user = ?",
            'i',
            Session::getUser()
        );
    }

    public function __construct() {
        $this->checkCookie();
    }

    /**
     * Check if the mail is already in the database
     *
     * @param string $mail
     * @return bool true if the mail is already in the database, false otherwise
     */
    public function checkUserMail($mail) {
        return Database::getInstance()->executeResults(
            "SELECT * FROM `users` WHERE mail = ?",
            's',
            $mail
        ) != [];
    }

    /**
     * Login the user.
     *
     * @param string $mail
     * @param string $password
     * @param bool $remember, if the user wants to be remembered stored in a crypted token cookie
     * 
     * @return bool true if the user is logged in, false otherwise
     */
    public function login($mail, $password, $remember) {
        $result = Database::getInstance()->executeResults(
            "SELECT * FROM `users` WHERE `mail` = ? AND `password` = ?",
            'ss',
            $mail, $this->encryptPassword($password)
        );
        if (!empty($result)) {
            $result = $result[0];
            if (filter_var($remember, FILTER_VALIDATE_BOOLEAN)) {
                $this->setCookie($this->generateToken($result['id_user'], $result['su']));
            }
            $this->refreshSession(['id_user' => $result['id_user'], 'isSuperUser' => $result['su']]);
            return true;
        }
        return false;
    }

    /**
     * Logout the user.
     *
     * @return bool true if the user is logged out, false otherwise
     */
    public function logout() {
        // delete cookie also if not exists
        setcookie(self::$cookieAuthName, '', [
            'expires' => time() - self::$cookieAuthTime,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        Session::destroy();
        return true;
    }

    /**
     * Register a new user
     *
     * @param string $mail
     * @param string $password
     * @param int|null $su, if the user is a super user (default no).
     * @param int|null $notifications, if the user wants to receive the notification (default no).
     * 
     * @return bool true if the user is registered, false otherwise
     */
    public function register($mail, $password, $notifications = 1) {
        if (!$this->isValidMail($mail)) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `users` (mail, password, notifications) VALUES (?, ?, ?)",
            'ssi',
            $mail, $this->encryptPassword($password), filter_var($notifications, FILTER_VALIDATE_BOOLEAN)
        );
    }

    /**
     * Send an mail (fake send), it set as password 'forgot'.
     *
     * @param string $mail
     * @return bool
     */
    public function forgotPassword($mail) {
        if (!$this->isValidMail($mail)) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "UPDATE `users` SET password = ? WHERE mail = ?",
            'ss',
            $this->encryptPassword('forgot'), $mail
        );
    }

    public function registerSuperUser($mail, $password) {
        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `users` (mail, password, su) VALUES (?, ?, 1)",
            'ss',
            $mail, $this->encryptPassword($password)
        );
    }
}
