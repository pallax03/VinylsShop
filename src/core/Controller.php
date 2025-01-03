<?php
class Controller {

    // private $head = [
    //     'title' => 'Home',
    //     'styles' => ['main.css'],
    //     'scripts' => ['main.js']
    // ];

    // private function configHead($title, $styles = [], $scripts = []) {
    //     $this->head['title'] = $title;
    //     $this->head['styles'] = $styles;
    //     $this->head['scripts'] = $scripts;
    // }

    /**
     * Redirect the admin to the dashboard page if logged as super user 
    */
    protected function redirectSuperUser() {
        $this->redirectIf(Session::isSuperUser(), '/dashboard');
    }

    /**
     * Redirect the user to the login page if not logged 
    */
    protected function redirectUser() {
        $this->redirectIf(!Session::isLogged(), '/user');
    }

    protected function redirectIf($condition, $location) {
        if ($condition) {
            header("Location: $location");
            exit();
        }
    }

    protected function render($page, $head = [], $data = []) {
        extract($head);
        
        extract($data);
        $page = PAGES . $page . '.php';
        
        include UTILITY . 'Render.php';
    }

    protected function renderApi($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>