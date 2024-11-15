<?php
final class AuthModel {

    # generate token with user id and isSuperUser.
    private function generateToken($userId, $isSuperUser) {
        $key = $_ENV['JWT_SECRET_KEY'];
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode(['user_id' => $userId, 'isSuperUser' => $isSuperUser, 'exp' => time() + 3600]);  // Token valido per 1 ora
    
        // Codifica in base64
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    
        // Crea la firma
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
        // Token finale
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    private function verifyToken($token) {
        $key = $_ENV['JWT_SECRET_KEY'];
        // check if token is Barer token or only token
        if (strpos($token, 'Bearer ') !== false)
            $token = str_replace('Bearer ', '', $token);

        $parts = preg_split('/\./', $token);
        
        if (count($parts) === 3) {
            $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1]));
            $signatureProvided = $parts[2];
    
            // Verifica la firma
            $signature = hash_hmac('sha256', $parts[0] . "." . $parts[1], $key, true);
            $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
            if ($base64UrlSignature === $signatureProvided) {
                $payloadArray = json_decode($payload, true);
    
                // Verifica se il token è scaduto
                if ($payloadArray['exp'] >= time()) {
                    return $payloadArray;  // Token valido
                } else {
                    return false;  // Token scaduto
                }
            }
        }
        return false;  // Token non valido
    }

    private function setCookie($token) {
        setcookie('token', $token, [
            'expires' => time() + 3600,  // Scadenza di 1 ora (modificabile)
            'path' => '/',               // Disponibile su tutto il sito
            'secure' => true,            // Solo tramite HTTPS
            'httponly' => true,          // Non accessibile via JavaScript
            'samesite' => 'Strict'       // Anti-CSRF, non invia il cookie da altre origini
        ]);
    }

    public function login($mail, $password) {
        $db = Database::getInstance()->getConnection();

        $query = "SELECT * FROM `Users` WHERE mail = ? AND password = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $mail, $password);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $this->setCookie($token = $this->generateToken($result['id_user'], $result['su']));
            $_SESSION['User'] = $result;
            return ['token' => $token, 'user' => $result];
        }
        return ['error' => 'Credenziali non valide']; 
    }

    public function logout() {
        setcookie('token', '', time() - 3600, '/');
        session_destroy();
        return ['message' => 'Logout effettuato'];
    }

    public function register() {
        echo 'register';
    }

    public function forgotPassword() {
        echo 'forgotPassword';
    }

    public function deleteUser($id_user, $token) {
        $decoded = $this->verifyToken($token);
        if (!$decoded || !$decoded['isSuperUser']) {
            return ['message' => 'Accesso negato'];
        }

        $db = Database::getInstance()->getConnection();

        $query = "DELETE FROM `Users` WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ['message' => 'Utente eliminato con successo'];
        } else {
            return ['message' => 'Nessun utente trovato'];
        }
    }
}
