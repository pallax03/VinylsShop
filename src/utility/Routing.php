<?php
    // Load Controllers
    // Controller has: Models (DB tables) -> views (🏠) and apis (🍽️) (requests)

    require_once CONTROLLERS . '/HomeController.php';       // 📀: Auth - Vinyl (Artist - Track) - Cart (🚩) -> 🏠 Home, Search, Login, Logout.
    //require_once CONTROLLERS . '/CartController.php';       // 🛒: Vinyl (Artist - Track) - Cart - User (Address - Card) -> 🏠 Cart, ManageCart.
    require_once CONTROLLERS . '/UserController.php';       // 👤: User (Address - Card) - Cart - Order ( + Shipping) - (Auth) -> 🏠 User, ManageAddress, ManageCard.
    //require_once CONTROLLERS . '/OrderController.php';      // 📦: Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth -> 🏠 Order, AddOrder.
    //require_once CONTROLLERS . '/DashboardController.php';  // 📊: (if Auth ⭐️) *EVERY MODEL* -> 🏠 Dashboard, AddVinyl (AddArtist - AddTrack), UpdateVinyl, AddAdmin.
    
    $router = new Router(new Request(), new Response());

    // documentation patterns:
        // --- Controller.php ---
        // views (🏠) / apis (🍽️) ~ notes... -> needed models.php


    // 📀:
    // --- HomeController.php --- (models: Auth Vinyl)
    // # 🏠 [Home] ~ (no need to be logged) -> Vinyl
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/', [HomeController::class, 'index']); // // # [TODELETE] -> per sam allenati con le post request e vedi come funzionano
    // # 🍽️ [Search] -> Vinyl
    // $router->get('/search', [HomeController::class, 'search']);
    // # 🍽️  [Login] ~ if mail not exists: register -> Auth
    $router->post('/login', [AuthController::class, 'login']); 
    // # 🍽️  [Logout] -> Auth
    $router->get('/logout', [AuthController::class, 'logout']);
    // # 🏠 [Devs] ~ README.md
    // $router->get('/devs', [HomeController::class, 'devs']);

    // 🛒:
    // --- CartController.php --- (models: Vinyl (+ Artist) - Cart - User) 
    // # 🏠 [Cart] ~ Stored in session if logged need to SyncCart with DB -> Vinyl - Cart - User
    // $router->get('/cart', [CartController::class, 'index']);
    // # 🍽️ [ManageCart] -> Vinyl - Cart - User
    // $router->post('/cart/manage', [CartController::class, 'manage']); 
    // # 🍽️ [SyncCart] -> Cart - User
    // $router->get('/cart/sync', [CartController::class, 'sync']); 
    // 🚩 # 🍽️ [Price] ~ preview price -> Cart - Vinyl - Shipping 
    // 🚩 $router->get('/cart/price', [CartController::class, 'price']); 
    // # 🏠 [Checkout] ~ go onto the checkout page -> Auth - User (Address - Card) - Cart - Vinyl (Artist) - Shipping - Order - Discount.
    // $router->get('/checkout', [CartController::class, 'checkout']);
    // # 🍽️ [Checkout] ~ request the checkout can handle errors if valid make the order and shipping -> Auth - User (Address - Card)
    // $router->post('/checkout', [CartController::class, 'pay']); 


    // 👤:
    // --- UserController.php --- (models: Auth - User (Address - Card))
    // # 🏠 [User] ~ if not logged: *login form* else: user infos n' list of orders + shipping -> Auth - User - Order - Shipping
    $router->get('/user', [UserController::class, 'index']);
    // # 🍽️ [Default] ~ set an address or a card as default -> User - Address - Card
    // $router->get('/user/default', [UserController::class, 'default']); -> get or set the default address and card.
    // # 🍽️ [ManageAddress] ~ get / add or update an address (made by the same method) -> User - Address
    // $router->get('/user/address', [UserController::class, 'address']); -> get all the addresses.
    // $router->post('/user/address', [UserController::class, 'address']); -> return the address.
    // # 🍽️ [ManageCard] ~ get / add or update a card (maded by the same method) -> User - Card
    // $router->get('/user/card', [UserController::class, 'card']); ->get all the cards.
    // $router->post('/user/card', [UserController::class, 'card']); -> return the card.


    // 📦:
    // --- OrderController.php --- (models: Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth)
    // # 🏠 [Order] ~ page of the specific order  -> Auth - User - Order - Shipping - Vinyl
    // $router->get('/order', [OrderController::class, 'index']);
    // # 🚩 🍽️ [Orders] ~ list of all the orders -> Auth - User - Order - Shipping - Vinyl
    // 🚩 $router->get('/orders', [OrderController::class, 'orders']);


    // 📊:
    // --- DashboardController.php --- (models: *EVERY MODEL*)
    // # 🏠 [Dashboard] ~ -> Auth.
    // $router->get('/dashboard', [DashboardController::class, 'index']);
    // # 🍽️ [AddVinyl] ~ add or update a vinyl -> Auth - Vinyl - Artist - Track.
    // $router->post('/vinyl', [DashboardController::class, 'addVinyl']);
    // # 🍽️ [DeleteVinyl] ~ -> Auth - Vinyl - Artist - Track.
    // $router->delete('/vinyl', [DashboardController::class, 'deleteVinyl']);


    // dispatch route
    $router->dispatch();
?>