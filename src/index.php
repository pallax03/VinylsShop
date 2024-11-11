<?php
# define root path
define ('ROOT', dirname(__FILE__));
define ('CONFIG', ROOT . '/config/');
define ('UTILITY', ROOT . '/utility/');
define ('MODELS', ROOT . '/models/');
define ('CONTROLLERS', ROOT . '/controllers/');
define ('PAGES', ROOT . '/views/pages/');
define ('COMPONENTS', ROOT . '/views/components/');

# load environment variables
require_once CONFIG . 'LoadEnvs.php';          // Load environment variables
LoadEnv::load(['.env', '.spotify.env']);   // Load environment variables from those files

# load utilities
require_once UTILITY . 'DatabaseUtility.php';   // Database utility functions
require_once UTILITY . 'Router.php';           // Router utility functions
require_once UTILITY . 'Controller.php';       // Controller utility functions

# load Controllers and Models
require_once CONTROLLERS . '/HomeController.php';

# start session
session_start();

# connect to database
// DatabaseUtility::connect();
DatabaseUtility::setConfigEnv();

# define routes
$router = new Router();
$router->get('/', HomeController::class, 'index');

# dispatch route
$router->dispatch();
?>