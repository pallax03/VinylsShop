<?php
final class AuthModel {

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
        $parts = explode('.', $token);
        
        if (count($parts) === 3) {
            $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[0]));
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
    

    public function login($mail, $password) {
    $db = Database::getInstance()->getConnection();

    $query = "SELECT * FROM `Users` WHERE mail = ? AND password = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $mail, $password);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $token = $this->generateToken($result['id_user'], $result['su']);
        return ['token' => $token, 'user' => $result];
    } else {
        return false;  // Credenziali non valide
    }

        // // TO REDO
        // $token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        // if ($token) {
        //     $decoded = $this->verifyToken($token);
        //     if ($decoded && $decoded['role'] === 'admin') {
        //         echo "Autenticazione riuscita. Ruolo: " . $decoded['role'];
        //     } else {
        //         echo "Token non valido o accesso negato.";
        //     }
        // } else {
        //     echo "Nessun token fornito.";
        // }
    }

    public function logout() {
        echo 'logout';
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
