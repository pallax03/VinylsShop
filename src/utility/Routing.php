<?php
    # load Controllers
    require_once CONTROLLERS . '/HomeController.php';
    require_once CONTROLLERS . '/AuthController.php';
    
    $router = new Router(new Request(), new Response());
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/', [HomeController::class, 'index']);

    
    $router->post('/login', [AuthController::class, 'login']);
    // $router->delete('/api/user/{id}', [AuthController::class, 'deleteUser']);

    # dispatch route
    $router->dispatch();
?>