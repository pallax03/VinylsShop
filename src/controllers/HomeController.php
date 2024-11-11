<?php
class HomeController extends Controller {

    public function index() {
        $head = array('title' => 'Home', 'style'=> array(''),
         'header' => DatabaseUtility::connect() ? 'Database connected' : 'Database not connected');

        $this->render('home', $head);
    }
}
?>