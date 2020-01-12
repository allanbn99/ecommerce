<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Project\Page;
use \Project\PageAdmin;
use \Project\Model\User;
use \Project\Model\Category;

$app = new Slim();

$app->config('debug', true);

require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");
require_once("admin-products.php");

$app->run();

 ?>