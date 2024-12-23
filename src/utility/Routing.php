<?php
    // Load Controllers
    // Controller has: Models (DB tables) -> views (🏠) and apis (🍽️) (requests)

    require_once CONTROLLERS . '/HomeController.php';       // 📀: Auth - Vinyl (Artist - Track) - Cart (🚩) -> 🏠 Home, Search, Login, Logout.
    require_once CONTROLLERS . '/CartController.php';       // 🛒: Vinyl (Artist - Track) - Cart - User (Address - Card) -> 🏠 Cart, ManageCart.
    require_once CONTROLLERS . '/UserController.php';       // 👤: User (Address - Card) - Cart - Order ( + Shipping) - (Auth) -> 🏠 User, ManageAddress, ManageCard.
    //require_once CONTROLLERS . '/OrderController.php';      // 📦: Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth -> 🏠 Order, AddOrder.
    //require_once CONTROLLERS . '/DashboardController.php';  // 📊: (if Auth ⭐️) *EVERY MODEL* -> 🏠 Dashboard, AddVinyl (AddArtist - AddTrack), UpdateVinyl, AddAdmin.
    //DELETEME
    require_once CONTROLLERS .'/VinylController.php';
    
    $router = new Router(new Request(), new Response());

    // documentation patterns:
        // --- Controller.php ---
        // views (🏠) / apis (🍽️) ~ notes... -> needed models.php


    // 📀: !!!(ALEX & SAM)
    // --- HomeController.php --- (models: Auth Vinyl)
    // # 🏠 [Home] ~ (no need to be logged) -> Vinyl
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/', [HomeController::class, 'index']); // // # [TODELETE] -> per sam allenati con le post request e vedi come funzionano
    // # 🍽️ [Search] -> Vinyl !!!(SAM)
    $router->get('/search', [HomeController::class, 'search']);
    // # 🍽️  [Login] ~ if mail not exists: register -> Auth
    $router->post('/login', [HomeController::class, 'login']); 
    // # 🍽️  [Logout] -> Auth
    $router->get('/logout', [HomeController::class, 'logout']);
    // # 🏠 [Devs] ~ README.md
    // $router->get('/devs', [HomeController::class, 'devs']);

    // 🛒: !!!(SAM)
    // --- CartController.php --- (models: Vinyl (+ Artist) - Cart - User) 
    // # 🏠 [Cart] ~ Stored in session if logged need to SyncCart with DB -> Vinyl - Cart - User
    $router->get('/cart', [CartController::class, 'index']);
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

    // 👤: (ALEX)
    // --- UserController.php --- (models: Auth - User (Address - Card))
    // # 🏠 [User] ~ if not logged: *login form* else: user infos n' list of orders + shipping -> Auth - User - Order - Shipping
    $router->get('/user', [UserController::class, 'index']);
    // # 🍽️ [GetUser] ~ get user infos an admin can get all -> Auth - User
    $router->get('/user/get', [UserController::class, 'getUser']);
    // # 🍽️ [UpdateUser] ~ update user infos -> Auth - User
    // $router->post('/user', [UserController::class, 'updateUser']);
    // # 🍽️ [DeleteUser] ~ delete the user -> Auth - User
    $router->delete('/user', [UserController::class, 'deleteUser']);
    // # 🍽️ [Default] ~ set an address or a card as default -> User - Address - Card
    $router->post('/user/defaults', [UserController::class, 'setUserDefaults']); // -> get or set the default address and card.
    // # 🏠 [Addresses] ~ if not logged: return to /user else: user's addresses -> Auth - User (Addresses)
    $router->get('/user/addresses', [UserController::class, 'addresses']);
    // # 🍽️ [ManageAddress] ~ get / add or update an address (made by the same method) -> User - Address
    $router->get('/user/address', [UserController::class, 'getAddress']); // -> get all the addresses.
    $router->delete('/user/address', [UserController::class, 'deleteAddress']); // -> delete the address.
    $router->post('/user/address', [UserController::class, 'setAddress']); // -> return the address.
    // # 🏠 [Cards] ~ if not logged: return to /user else: user's cards -> Auth - User (Card)
    $router->get('/user/cards', [UserController::class, 'cards']);
    // # 🍽️ [ManageCard] ~ get / add or update a card (maded by the same method) -> User - Card
    $router->get('/user/card', [UserController::class, 'getCard']); // ->get all the cards.
    $router->delete('/user/card', [UserController::class, 'deleteCard']); // -> delete the card.
    $router->post('/user/card', [UserController::class, 'setCard']); // -> return the card.
    

    // 📦: (ALEX)
    // --- OrderController.php --- (models:  Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth)
    // # 🏠 [Order] ~ page of the specific order '?id_order='  -> Auth - User - Order - Shipping - Vinyl
    // $router->get('/order', [OrderController::class, 'index']);
    // # 🚩 🍽️ [Orders] ~ list of all the orders -> Auth - User - Order - Shipping - Vinyl
    // 🚩 $router->get('/orders', [OrderController::class, 'orders']);

    // 📊: (SAM)
    // --- DashboardController.php --- (models: *EVERY MODEL*)
    // # 🏠 [Dashboard] ~ -> Auth.
    $router->get('/dashboard', [HomeController::class, 'dashboard']);
    // # 🍽️ [AddVinyl] ~ add or update a vinyl -> Auth - Vinyl - Artist - Track.
    // $router->post('/vinyl', [DashboardController::class, 'addVinyl']);
    // # 🍽️ [DeleteVinyl] ~ -> Auth - Vinyl - Artist - Track.
    // $router->delete('/vinyl', [DashboardController::class, 'deleteVinyl']);

    // [Vinyls]
    // $router->get('/vinyls', [VinylController::class, 'index']); per restituire la pagina
    // $router->get('/api/vinyls', [VinylController::class, 'getVinyls']); per cercare i vinili

    // dispatch route
    $router->dispatch();
?>