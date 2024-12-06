<?php
    # load Controllers
    require_once CONTROLLERS . '/HomeController.php'; // Vinyl - Cart
    require_once CONTROLLERS . '/AuthController.php'; // Login - Register - Logout
    require_once CONTROLLERS . '/UserController.php'; // Models: Address - Payment - Order - (Auth).
    // require_once CONTROLLERS . '/DashboardController.php'; // Models: Vinyl - Order - (Auth). ???
    
    
    $router = new Router(new Request(), new Response());

    // # to understand the routing, maybe it can be part of HomeController
    // $router->get('/login', [AuthController::class, 'login']);
    $router->post('/login', [AuthController::class, 'login']); // if mail not exists, register user
    $router->get('/logout', [AuthController::class, 'logout']);
    // [POST] /register -> register a new user
    // $router->post('/register', [AuthController::class, 'register']); 

    // -----------------
    // # PAGE [Home] -> (no need to be logged)          //HomeController.php (models: Vinyl - Cart) 
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/', [HomeController::class, 'index']); // per sam allenati con le post request e vedi come funzionano

    // ## [Vinyls]
    // [GET] /api/vinyls-> get all vinyls (semplified json for *fast* searching)
    // [GET] /api/vinyl + '?id_vinyl= ' -> get vinyl by id (full vinyl json (artist, album, tracks))
    
    // ## [Cart]
    // [GET] /api/cart -> get cart of user / session
    // [POST] /api/cart -> add vinyl to cart, update quantity of vinyl in cart (if 0 remove from cart)    

    // -----------------
    // # PAGE [User] -> (need to be logged)          //UserController.php (models: Auth - Address - Payment - Order)
    $router->get('/user', [UserController::class, 'index']);
    // ## [Address]
    // [GET] /api/user/address -> get all address of user
    // [POST] /api/user/address -> add new address or update an already existing address
    // [DELETE] /api/user/address + '?id_address=2' -> delete an address
    
    // ## [Payment] (Method of Payment)
    // [GET] /api/user/payment -> get all payment of user
    // [POST] /api/user/payment -> add new payment (cannot update payment)
    // [DELETE] /api/user/payment + '?id_payment=2' -> delete a payment

    // ## [Order]
    // [GET] /api/user/orders -> get all order of user and the shipping of the order
    // [POST] /api/user/order -> go to payment page and create an order (take all vinyls in cart) and create a shipping for the order.


    // -----------------
    // ## [Dashboard]

    // ## [Vinyl]
    // [POST] /api/vinyl -> add new vinyl  or update an already existing vinyl (artist, album, tracks)
    // [DELETE] /api/vinyl + '?id_vinyl=2' -> delete a vinyl

    // ## [User]
    // [GET] /api/users -> get all users (id, mail, isSuperUser, newsletter), address and payments of each user
    // [POST] /api/admin -> add new admin user

    // ### [Order]
    // [GET] /api/orders + '?id_user' -> get all orders and the shipping of the order of a user
    // [POST] /api/order + '?id_order=2' -> update an order (status, shipping)

    // [DELETE] /api/user + '?id_user=2' + 'Authorization Bearer: token' -> deleteUser if isSuperUser logged

    // [Vinyls]
    // $router->get('/vinyls', [VinylController::class, 'index']); per restituire la pagina
    // $router->get('/api/vinyls', [VinylController::class, 'getVinyls']); per cercare i vinili

    # dispatch route
    $router->dispatch();
?>