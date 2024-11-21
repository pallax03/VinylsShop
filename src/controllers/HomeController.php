<?php
class HomeController extends Controller {

    private $model = null;

    public function __construct() {
        require_once MODELS . 'AuthModel.php';
        $this->model = new AuthModel();
    }

    public function index(Request $request, Response $response) {
        $this->model->checkAuth();
        $data = $request->getBody();
        $title = $data['title'] ?? 'Home';
        $head = array('title' => $title, 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');

        $data = $this->model->getUser(Session::getUser()) ?? [];
        $this->render('home', $head, $data);
    }
}
?>