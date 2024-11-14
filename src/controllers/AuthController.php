<?php
final class AuthController extends Controller {

    private $model = null;
    function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->model = new AuthModel();
    }

    public function login(Request $request, Response $response) {
        // JWT token for admin users
        $body = $request->getBody();
        $result = $this->model->login($body['mail'], $body['password']);
        echo json_encode($result);
        // $response->redirect('/');
    }

    public function logout() {
        // $this->model->logout();
        echo 'logout';
    }

    public function register() {
        // $this->model->register();
        echo 'register';
    }

    public function forgotPassword() {
        // $this->model->forgotPassword();
        echo 'forgotPassword';
    }

    // private function checkToken($token) {
    //     // Esempio di utilizzo
    //     $token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
    //     if ($token) {
    //         $decoded = $this->model->verifyToken($token);
    //         if ($decoded && $decoded['role'] === 'admin') {
    //             echo "Autenticazione riuscita. Ruolo: " . $decoded['role'];
    //         } else {
    //             echo "Token non valido o accesso negato.";
    //         }
    //     } else {
    //         echo "Nessun token fornito.";
    //     }
    // }

    public function deleteUser(Request $request, Response $response) {
        $body = $request->getBody();
        $result = $this->model->deleteUser($body['id_user'], $request->getAuthentication());
        echo json_encode($result);
    }
}
