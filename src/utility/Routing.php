<?php
    // Load Controllers
    require_once CONTROLLERS . '/HomeController.php';       // 🏡: Auth - Vinyl (Artist - Track).
    require_once CONTROLLERS .'/VinylController.php';       // 📀: Vinyl (Artist - Track) - Cart.
    require_once CONTROLLERS . '/CartController.php';       // 🛒: Vinyl (Artist - Track) - Cart - User (Address - Card).
    require_once CONTROLLERS . '/UserController.php';       // 👤: User (Address - Card) - Cart - Order ( + Shipping) - (Auth).
    require_once CONTROLLERS . '/OrderController.php';      // 📦: Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth.
    
    $router = new Router(new Request(), new Response());

// ?: --- Controller.php --- (models: ...)
    // views (🏠) / apis (🍽️) ~ notes... -> needed models.php


// 🏡: --- HomeController.php --- (models: Auth Vinyl)
    // # 🏠 [Home] ~ (no need to be logged) -> Vinyl
    $router->get('/', [HomeController::class, 'index']);
    // # 🍽️ [Notifications] ~ '?id_user='  -> Notifications
    $router->get('/notifications', [HomeController::class, 'notifications']);
    // # 🍽️ [Search] -> Vinyl
    $router->get('/search', [HomeController::class, 'search']);
    // # 🍽️  [Login] -> Auth
    $router->post('/login', [HomeController::class, 'login']);
    // # 🍽️  [Register] -> Auth
    $router->post('/register', [HomeController::class, 'register']);
    // # 🍽️  [Logout] -> Auth
    $router->get('/logout', [HomeController::class, 'logout']);
    // # 🏠 [Devs] ~ README.md
    // $router->get('/devs', [HomeController::class, 'devs']);
    // # ❌ DESTROY ALL (SESSION)
    $router->get('/cache', [HomeController::class, 'reset']);

    // ⭐️ ADMIN HOME ~ a not admin can't access to the dashboard. (will be redirected to the home page)
    // # 🏠 [Dashboard] -> Auth.
    $router->get('/dashboard', [HomeController::class, 'dashboard']);
    $router->get('/dashboard/albums', [HomeController::class, 'dashboardAlbums']);
    $router->get('/dashboard/shoppings', [HomeController::class, 'dashboardShoppings']);
    $router->get('/dashboard/users', [HomeController::class, 'dashboardUsers']);


// 📀: --- VinylController.php --- (models: Vinyl (Artist - Track) - Cart)
    // # 🏠 [Vinyl] ~ page of the specific vinyl '?id_vinyl=' -> Vinyl (Artist - Track)
    $router->get('/vinyl', [VinylController::class, 'index']);
    // # 🍽️ [AddVinyl] ~ add or update a vinyl -> Auth - Vinyl - Artist - Track.
    $router->post('/vinyl', [VinylController::class, 'setVinyl']);
    // # 🍽️ [DeleteVinyl] ~ -> Auth - Vinyl - Artist - Track.
    $router->delete('/vinyl', [VinylController::class, 'deleteVinyl']);
    $router->get('/albums', [VinylController::class, 'getAlbums']);


// 🛒: --- CartController.php --- (models: Vinyl (+ Artist) - Cart - User) 
    // # 🏠 [Cart] ~ Stored in session if logged need to SyncCart with DB -> Vinyl - Cart - User
    $router->get('/cart', [CartController::class, 'index']);
    // # 🍽️ [GetCart] -> Vinyl - Cart
    $router->get('/cart/get', [CartController::class, 'get']);
    // # 🍽️ [ManageCart] -> Vinyl - Cart - User
    $router->post('/cart', [CartController::class, 'manage']); 
    // # 🍽️ [SyncCart] -> Cart - User
    $router->get('/cart/sync', [CartController::class, 'sync']); 
    // # 🏠 [Checkout] ~ go onto the checkout page -> Auth - User (Address - Card) - Cart - Vinyl (Artist) - Shipping - Order - Discount.
    $router->get('/checkout', [CartController::class, 'checkout']);
    // # 🍽️ [Total] ~ request the checkout Total (for discount code) -> Auth - Cart - Order 
    $router->get('/checkout/total', [CartController::class, 'getTotal']); 
    // # 🍽️ [Pay] ~ request the checkout payment can handle errors -> Auth - Cart - Order - Vinyl
    $router->post('/checkout', [CartController::class, 'pay']); 


// 👤: --- UserController.php --- (models: Auth - User (Address - Card))
    // # 🏠 [User] ~ if not logged: *login form* else: user infos n' list of orders + shipping -> Auth - User - Order - Shipping
    $router->get('/user', [UserController::class, 'index']);
    // # 🍽️ [GetUser] ~ get user infos an admin can get any one -> Auth - User
    $router->get('/user/get', [UserController::class, 'getUser']);
    // # 🍽️ [UpdateUser] ~ update user infos -> Auth - User
    $router->post('/user', [UserController::class, 'updateUser']); // like newsletter i can update the user in defaults.
    // 🚩 # 🍽️ [DeleteUser] ~ delete the user -> Auth - User
    $router->delete('/user', [UserController::class, 'deleteUser']);
    // # 🍽️ [Default] ~ set an address or a card as default -> User - Address - Card
    $router->post('/user/defaults', [UserController::class, 'setUserDefaults']); // -> set the default address and card.
    // # 🏠 [Addresses] ~ if not logged: return to /user else: user's addresses -> Auth - User (Addresses)
    $router->get('/user/addresses', [UserController::class, 'addresses']);
    // # 🍽️ [ManageAddress] ~ get / add or update an address (made by the same method) -> User - Address
    $router->get('/user/address', [UserController::class, 'getAddress']); // -> get all or an addresses.
    $router->delete('/user/address', [UserController::class, 'deleteAddress']); // -> delete the address.
    $router->post('/user/address', [UserController::class, 'setAddress']); // -> add a new address.
    // # 🏠 [Cards] ~ if not logged: return to /user else: user's cards -> Auth - User (Card)
    $router->get('/user/cards', [UserController::class, 'cards']);
    // # 🍽️ [ManageCard] ~ get / add or update a card (maded by the same method) -> User - Card
    $router->get('/user/card', [UserController::class, 'getCard']); // ->get all or a card.
    $router->delete('/user/card', [UserController::class, 'deleteCard']); // -> delete the card.
    $router->post('/user/card', [UserController::class, 'setCard']); // -> add a new card.
    
    // ⭐️ ADMIN 
    // # 🏠 [Users] ~ get all users.
    $router->get('/users', [UserController::class, 'users']);


// 📦: --- OrderController.php --- (models:  Vinyl (Artist - Track) - Cart - Order ( + Shipping) - User (Address - Card) - Auth)
    // # 🏠 [Order] ~ page of the specific order '?id_order='  -> Auth - User - Order - Shipping - Vinyl
    $router->get('/order', [OrderController::class, 'index']);
    // # 🍽️ [Orders] ~ list of all the orders -> Auth - User - Order - Shipping - Vinyl
    $router->get('/orders', [OrderController::class, 'getOrders']);
    // # 🍽️ [Shippings] ~ update shipping info -> Auth - Shipping
    $router->post('/shipping', [OrderController::class, 'setShipping']);
    // # 🍽️ [Coupons] ~ list of all the coupons -> Coupons
    $router->get('/coupons', [OrderController::class, 'getCoupons']);

    // ⭐️ ADMIN -> need to be an admin to access to the following routes.
    $router->post('/coupon', [OrderController::class, 'setCoupon']); // ->  add / update a coupon.
    $router->delete('/coupon', [OrderController::class, 'deleteCoupon']); // -> delete the coupon.

    
    $router->dispatch();
?>