<?php
    # load Controllers
    require_once CONTROLLERS . '/HomeController.php';
    require_once CONTROLLERS . '/AuthController.php';
    
    $router = new Router(new Request(), new Response());

    // [Home]
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/', [HomeController::class, 'index']);

    // [Auth]
    // $router->get('/login', [AuthController::class, 'login']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/logout', [AuthController::class, 'logout']);
    
    // [DELETE] /api/user + '?id_user=2' + 'Authorization Bearer: token' -> deleteUser if isSuperUser logged
    $router->delete('/api/user', [AuthController::class, 'deleteUser']);
    // $router->get('/callback', [AuthController::class, 'callback']);
    
    // $router->get('/register', [AuthController::class, 'register']);
    // $router->post('/register', [AuthController::class, 'register']);


    # dispatch route
    $router->dispatch();
?>