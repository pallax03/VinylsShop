<?php
class HomeController extends Controller {

    public function index(Request $request, Response $response) {
        $data = $request->getBody();
        $title = $data['title'] ?? 'Home';
        $head = array('title' => $title, 'style'=> array(''),
         'header' => Database::getInstance()->getConnection() ? 'Database connected' : 'Database not connected');

        $this->render('home', $head);
    }
}
?>