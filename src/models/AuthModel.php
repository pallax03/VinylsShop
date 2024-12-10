<?php
final class AuthModel {

    private $cookieAuthName = 'user_auth';

    private function encryptPassword($password) {
        return md5($password);
    }

    private function generateToken($userId, $isSuperUser) {
        $key = $_ENV['JWT_SECRET_KEY'];
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode(['id_user' => $userId, 'isSuperUser' => $isSuperUser, 'exp' => time() + 3600]));
        $signature = hash_hmac('sha256', "$header.$payload", $key, true);
        $signature = base64_encode($signature);
        return "$header.$payload.$signature";
    }

    // refresh the session with the user info (id, su)
    private function refreshSession($userInfo) {
        Session::set('User', ['id_user' => $userInfo['id_user'], 'su' => $userInfo['isSuperUser']]);
    }

    // check if the token is valid, if it is refresh the session, else logout.
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
        return false;
    }

    private function setCookie($token) {
        setcookie($this->cookieAuthName, $token, [
            'expires' => time() + 3600,  // Scadenza di 1 ora (modificabile)
            'path' => '/',               // Disponibile su tutto il sito
            'secure' => true,            // Solo tramite HTTPS
            'httponly' => true,          // Non accessibile via JavaScript
            'samesite' => 'Strict'       // Anti-CSRF, non invia il cookie da altre origini
        ]);
    }

    private function isValidMail($mail) {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    /*
    * This function checks if the user is logged in
    * checks if the cookie is set, if it is, verifies the token and set is session
    * after it checks if the user not exist in the database, if true logout.
    * @return bool
    */
    public function checkAuth() {
        if (!isset($_COOKIE[$this->cookieAuthName])) {
            return false;
        }
        $this->verifyToken($_COOKIE[$this->cookieAuthName]);
        if (!$this->fetchUser()) {
            $this->logout();
            header('Location: /user');
        }
    }


    public function fetchUser() {
        return Database::getInstance()->executeResults(
            "SELECT * FROM `Users` WHERE id_user = ?",
            'i',
            Session::getUser()
        );
    }

    public function __construct() {
        $this->checkAuth();
    }

    public function checkUserMail($mail) {
        return Database::getInstance()->executeResults(
            "SELECT * FROM `Users` WHERE mail = ?",
            's',
            $mail
        ) != [];
    }

    public function login($mail, $password) {
        $result = Database::getInstance()->executeResults(
            "SELECT * FROM `Users` WHERE `mail` = ? AND `password` = ?",
            'ss',
            $mail, $this->encryptPassword($password)
        );
        $result = !empty($result) && count($result) > 0 ? $result[0] : false;
        if ($result) {
            $this->setCookie($this->generateToken($result['id_user'], $result['su']));
            $this->refreshSession(['id_user' => $result['id_user'], 'isSuperUser' => $result['su']]);
            return true;
        }

        return false;
    }

    public function logout() {
        // delete cookie also if not exists
        setcookie($this->cookieAuthName, '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        Session::destroy();
        return true;
    }

    /*
    * This function registers a new user
    * @param string $mail
    * @param string $password 
    * @param int $su default 0
    * @param int $newsletter default 0
    * @return bool true if the user is registered, false otherwise
    */
    public function register($mail, $password, $su = 0, $newsletter = 0) {
        if (!$this->isValidMail($mail)) {
            return 'not a valid mail';
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `Users` (mail, password, su, newsletter) VALUES (?, ?, ?, ?)",
            'ssii',
            $mail, $this->encryptPassword($password), $su ?? 0, $newsletter ?? 0
        );
    }

    public function forgotPassword($mail) {
        throw new Exception('Not implemented');
    }
}
