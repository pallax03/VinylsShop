<?php
# define root path
define ('ROOT', dirname(__FILE__));
define ('CONFIG', ROOT . '/config/');
define ('CORE', ROOT . '/core/');
define ('UTILITY', ROOT . '/utility/');
define ('MODELS', ROOT . '/models/');
define ('CONTROLLERS', ROOT . '/controllers/');
define ('PAGES', ROOT . '/views/pages/');
define ('COMPONENTS', ROOT . '/views/components/');

# load environment variables
require_once CONFIG . 'LoadEnvs.php';          // Load environment variables
LoadEnv::load(['.env', '.admin.env']);   // Load environment variables from those files

# load core files (mvc)
require_once CORE . 'Request.php';       // Router->Request
require_once CORE . 'Response.php';       // Router->Response
require_once CORE . 'Router.php';
require_once CORE . 'Controller.php';

# load utilities
require_once UTILITY . 'Database.php';   // Database utility functions
require_once UTILITY . 'Session.php';   // Session utility functions

# start session
Session::start();

# instance the database
Database::getInstance();

# routing
include UTILITY . 'Routing.php';
?>