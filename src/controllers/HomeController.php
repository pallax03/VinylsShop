<?php
class HomeController extends Controller {

    private $auth_model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->auth_model = new AuthModel();
    }

    public function index(Request $request, Response $response) {
        $data = $request->getBody();
        $title = $data['title'] ?? 'Home';
        $head = array('title' => $title, 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');

        $this->render('home', $head, $data);
    }
}
?>