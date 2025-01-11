<?php
final class VinylController extends Controller {

    private $vinyl_model = null;
    private $notification_model = null;

    function __construct() {
        require_once MODELS . '/VinylsModel.php';
        $this->vinyl_model = new VinylsModel();

        require_once MODELS . '/NotificationModel.php';
        $this->notification_model = new NotificationModel();

        $this->notificateVinylQuantity();
    }
    
    private function notificateVinylQuantity() {
        $vinyls = $this->vinyl_model->getVinylsOptimized(['stock' => 0]);
        foreach ($vinyls as $vinyl) {
            $this->notification_model->broadcastFor(
                Database::getInstance()->executeResults("SELECT id_user FROM users WHERE su = 1"),
                "Vinyl " . $vinyl['title'] . " out of stock!",
                "/vinyl?id=" . $vinyl['id_vinyl']
            );
        }
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
        if(isset($body['cost']) && isset($body['rpm']) && isset($body['inch']) && isset($body['type']) && isset($body['stock']) && isset($body['album']) && isset($body['artist'])) {
            if ($this->vinyl_model->addVinyl($body['cost'], $body['rpm'], $body['inch'], $body['type'], $body['stock'], $body['album'], $body['artist'], $body['id_vinyl'] ?? null)) {
                $response->Success('Vinyl added / updated', $body);
                return;
            }
        }
        $response->Error('Vinyl not added / updated', $body);
    }

    function deleteVinyl(Request $request, Response $response) {
        $body = $request->getBody();
        if(!Session::isSuperUser()) {
            $response->Error('Not allowed to delete vinyls', $body);
            return;
        }
        if (isset($body['id_vinyl']) && $this->vinyl_model->deleteVinyl($body['id_vinyl'])) {
            $response->Success('Vinyl deleted', $body);
            return;
        }
        $response->Error('Vinyl not deleted', $body);
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

    // per il momento non è utile
    // function getAllVinyls(Request $request, Response $response) {
    //     if(!Session::isSuperUser()) {
    //         $response->Error('not allowed to see all vinyls');
    //         return;
    //     }
        
    //     $data = $this->vinyl_model->getVinyls(-1, null);
    //     $response->Success($data);
    // }
}

