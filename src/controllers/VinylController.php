<?php
final class VinylController extends Controller {

    private $model = null;

    function __construct() {
        require_once MODELS . '/VinylsModel.php';
        $this->model = new VinylsModel();
    }
    function index(Request $request, Response $response) {
        $body = $request->getBody();
        $result['vinyl'] = $this->model->getVinylDetails($body['id']);
        $result['suggested'] = $this->model->getSuggested($body['id']);
        $response->Success("", $result);
    }
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
