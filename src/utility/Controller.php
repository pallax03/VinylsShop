<?php
class Controller {



    // protected function redirect($url) {
    //     header('Location: ' . $url);
    //     exit();
    // }

    protected function render($page, $head = [], $data = []) {
        extract($head);
        
        extract($data);
        $page = PAGES . $page . '.php';
        
        include UTILITY . 'Render.php';
    }
}
?>