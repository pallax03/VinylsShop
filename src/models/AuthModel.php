<?php
final class AuthModel {

    private $cookieAuthName = 'user_auth';

    private function encryptPassword($password) {
        $key = $_ENV['JWT_SECRET_KEY'];
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
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
        $this->logout();
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

    /*
    * This function checks the authentication of the user
    * setting the session if the token is valid
    * else it returns false
    * @param string $header
    * @return bool
    */
    public function checkAuth() {
        if (isset($_COOKIE[$this->cookieAuthName])) {
            $this->verifyToken($_COOKIE[$this->cookieAuthName]);
        }
        return false;
    }

    public function login($mail, $password) {
        $db = Database::getInstance()->getConnection();

        $query = "SELECT * FROM `Users` WHERE mail = ? AND password = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $mail, $this->encryptPassword($password));
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $this->setCookie($token = $this->generateToken($result['id_user'], $result['su']));
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

    public function register($mail, $password, $su, $newsletter) {
        $db = Database::getInstance()->getConnection();
    
        $query = "INSERT INTO `Users` (mail, password, su, newsletter) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssii', $mail, $this->encryptPassword($password), $su, $newsletter);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function forgotPassword($mail) {
        return false;
    }

    public function deleteUser($id_user) {
        if (!Session::isSuperUser()) {
            return false;
        }

        $db = Database::getInstance()->getConnection();

        $query = "DELETE FROM `Users` WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_user);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function getUser($id_user) {
        if ($id_user === Session::getUser() || Session::isSuperUser()) {
            $db = Database::getInstance()->getConnection();

            $query = "SELECT * FROM `Users` WHERE id_user = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $id_user);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result;
        }
        return false;
    }
}
