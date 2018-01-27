<?php 

define("DIR_ROUTES", "routes/");
define("DIR_SYSTEM", "system/");

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

require_once(DIR_SYSTEM."functions.php");
require_once(DIR_ROUTES."site.php");
require_once(DIR_ROUTES."admin.php");
require_once(DIR_ROUTES."admin-users.php");
require_once(DIR_ROUTES."admin-categories.php");
require_once(DIR_ROUTES."admin-products.php");
require_once(DIR_ROUTES."admin-orders.php");

$app->run();

?>