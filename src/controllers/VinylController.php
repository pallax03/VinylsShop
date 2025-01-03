<?php
final class VinylController extends Controller {

    private $vinyl_model = null;

    function __construct() {
        require_once MODELS . '/VinylsModel.php';
        $this->vinyl_model = new VinylsModel();

        require_once MODELS . '/OrderModel.php';
    }
    
    function index(Request $request, Response $response) {
        $body = $request->getBody();
        $data['vinyl'] = $this->vinyl_model->getVinylDetails($body['id']);
        $data['suggested'] = $this->vinyl_model->getSuggested($body['id']);
        $head = array('title' => $data["vinyl"]["details"]["title"], 'style'=> array(''),
         'header' => "Oltre i " . OrderModel::$ShippingGoal . "€ spedizione gratuita!");
        $this->render('vinyls', $head, $data);
    }

    function getVinylsComponent(Request $request, Response $response) {
        $response->Component('/table/vinyls', ['vinyls' => $this->vinyl_model->getVinyls(0, [])]);
    }

    function addVinyl(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->vinyl_model->addVinyl($body['cost'], $body['rpm'], $body['inch'], $body['type'], $body['stock'], $body['album'], $body['artist'])) {
            $response->Success('Vinyl added', $body);
        } else {
            $response->Error('Error adding vinyl', $body);
        }
    }

}
// TODO
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
