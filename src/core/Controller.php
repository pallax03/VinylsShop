<?php
class Controller {


    protected function render($page, $head = [], $data = []) {
        extract($head);
        
        extract($data);
        $page = PAGES . $page . '.php';
        
        include UTILITY . 'Render.php';
    }
}
?>