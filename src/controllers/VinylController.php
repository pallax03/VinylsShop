<?php
final class VinylController extends Controller {

    private $vinyl_model = null;
    private $notification_model = null;

    function __construct() {
        require_once MODELS . '/VinylsModel.php';
        $this->vinyl_model = new VinylsModel();

        require_once MODELS . '/NotificationModel.php';
        $this->notification_model = new NotificationModel();
    }

    function index(Request $request, Response $response) {
        $body = $request->getBody();
        $data['vinyl'] = $this->vinyl_model->getVinylDetails($body['id'] ?? null);
        if (isset($body['id']) && !empty($data['vinyl'])) {
            $data['suggested'] = $this->vinyl_model->getSuggested($body['id']);
            $head = array('title' => $data["vinyl"]["details"]["title"], 'style'=> array(''),
             'header' => "Oltre i " . $_ENV['SHIPPING_GOAL'] . "€ spedizione gratuita!");
            $this->render('ecommerce/vinyl', $head, $data);
            return;
        }
        $head['title'] = "No vinyl is specified";
        $this->render('', $head, []);
    }

    function addVinyl(Request $request, Response $response) {
        $body = $request->getBody();
        if(!Session::isSuperUser()) {
            $response->Error('Not allowed to add vinyls', $body);
            return;
        }

        if ($this->vinyl_model->addVinyl($body['cost'] ?? null, $body['rpm'] ?? null, $body['inch'] ?? null, $body['type'] ?? null, $body['stock'] ?? null, $body['album'] ?? null, $body['id_vinyl'] ?? null)) {
            $response->Success('Vinyl ' . (isset($body['id_vinyl']) ? 'updated' : 'added'), $body);
            return;
        }
        $response->Error('Vinyl not ' . (isset($body['id_vinyl']) ? 'updated' : 'added'), $body);
    }

    function getAlbums(Request $request, Response $response) {
        $body = $request->getBody();
        $data = $this->vinyl_model->getAlbums($body);
        if(!empty($data)) {
            $response->Success($data, $body);
            return;
        }
        $response->Error('No albums found', $body);
    }

    function updateVinyl(Request $request, Response $response) {
        $body = $request->getBody();
        if ($this->vinyl_model->updateVinyl($body['id'], $body['cost'], null, null, null, $body['stock'], null)) {
            $response->Success('Vinyl succesfully updated');
            return;
        }
        $response->Error('Update not possible');
    }
}

