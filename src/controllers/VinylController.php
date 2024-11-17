<?php
final class VinylController extends Controller {

    private $model = new VinylsModel();

    function __construct() {
        require_once MODELS . 'VinylsModel.php';
        $this->model = new VinylsModel();
    }

    function getVinyls() {
        
    }

    /*
    public function login(Request $request, Response $response) {
        // JWT token for admin users
        $body = $request->getBody();
        $result = $this->model->login($body['mail'], $body['password']);
        echo json_encode($result);
        // $response->redirect('/');
    }

    public function logout(Response $response) {
        // $this->model->logout();
        echo json_encode(['error' => 'Not implemented']);
    }
    */
}
