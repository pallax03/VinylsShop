<?php
    # load Controllers
    // Controller has: Models (DB tables) -> views (🏠) and apis (🍽️) (requests)
    require_once CONTROLLERS . '/HomeController.php';       // 📀: Vinyl (Artist - Track) - Cart (🚩) -> 🏠 Home, Search.
    require_once CONTROLLERS . '/AuthController.php';       // 🔐: Auth -> Login, Logout.
    //require_once CONTROLLERS . '/CartController.php';       // 🛒: Vinyl (Artist - Track) - Cart - User (Address - Card) -> 🏠 Cart, ManageCart.
    require_once CONTROLLERS . '/UserController.php';       // 👤: User (Address - Card) - Cart - Order ( + Shipping) - (Auth) -> 🏠 User, ManageAddress, ManageCard.
    //require_once CONTROLLERS . '/OrderController.php';      // 📦: Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth -> 🏠 Order, AddOrder.
    //require_once CONTROLLERS . '/DashboardController.php';  // 📊: (if Auth ⭐️) *EVERY MODEL* -> 🏠 Dashboard, AddVinyl (AddArtist - AddTrack), UpdateVinyl, AddAdmin.
    
    $router = new Router(new Request(), new Response());

    // HowTo:
        // --- Controller.php ---
        // views (🏠) / apis (🍽️) ~ notes... -> needed models.php


    // 📀:
    // --- HomeController.php --- (models: Vinyl)
    // # 🏠 [Home] ~ (no need to be logged) -> Vinyl
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/', [HomeController::class, 'index']); // // # [TODELETE] -> per sam allenati con le post request e vedi come funzionano
    // # 🍽️ [Search] -> Vinyl
    // $router->get('/search', [HomeController::class, 'search']); 


    // 🔐:
    // --- AuthController.php --- (models: Auth) 
    // 🍽️  [Login] ~ if mail not exists: register -> Auth
    $router->post('/login', [AuthController::class, 'login']); 
    // 🍽️  [Logout] -> Auth
    $router->get('/logout', [AuthController::class, 'logout']);


    // 🛒:
    // --- CartController.php --- (models: Vinyl (+ Artist) - Cart - User) 
    // # 🏠 [Cart] ~ Stored in session if logged need to SyncCart with DB -> Vinyl - Cart - User
    // $router->get('/cart', [CartController::class, 'index']);
    // # 🍽️ [ManageCart] -> Vinyl - Cart - User
    // $router->post('/cart/manage', [CartController::class, 'manage']); 
    // # 🍽️ [SyncCart] -> Cart - User
    // $router->get('/cart/sync', [CartController::class, 'sync']); 


    // 👤:
    // --- UserController.php --- (models: Auth - User (Address - Card))
    // # 🏠 [User] ~ if not logged: *login form* else: user infos n' list of orders + shipping -> Auth - User - Order - Shipping
    $router->get('/user', [UserController::class, 'index']);
    // # 🍽️ [ManageAddress] ~ get / add or update an address (made by the same method) -> User - Address
    // $router->get('/user/address', [UserController::class, 'address']);
    // $router->post('/user/address', [UserController::class, 'address']); -> return the address.
    
    // # 🍽️ [ManageCard] ~ get / add or update a card (maded by the same method) -> User - Card
    // $router->get('/user/card', [UserController::class, 'card']); -> 🚩.
    // $router->post('/user/card', [UserController::class, 'card']); -> return the card.


    // 📦:
    // --- OrderController.php --- (models: Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth)
    // # 🏠 [Order] ~  -> Auth - User - Order - Shipping - Vinyl
    // $router->get('/order', [OrderController::class, 'index']);
    // # 🍽️ [ManageOrder] ~ get / add or update an address (maded by the same method) -> User - Address
    // $router->get('/user/address', [UserController::class, 'address']);
    // $router->post('/user/address', [UserController::class, 'address']); -> return the address 
    // # 🍽️ [ManageCard] ~ get / add or update a card (maded by the same method) -> User - Card
    // $router->get('/user/card', [UserController::class, 'card']); -> + '?id=?' ???
    // $router->post('/user/card', [UserController::class, 'card']); -> return the card 


    // 📊:
    // --- DashboardController.php --- (models: *EVERY MODEL*)
    // # 🏠 [Dashboard] ~ -> Auth.
    // $router->get('/dashboard', [DashboardController::class, 'index']);


    # dispatch route
    $router->dispatch();
?>