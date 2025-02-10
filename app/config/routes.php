<?php

use App\core\Router;
use App\controllers\front\eventController;
use App\controllers\front\UserController;
use App\controllers\back\dashboardController;
use App\controllers\back\categorieController;
use App\controllers\back\loginController;
use App\controllers\back\signupController;
use App\core\Auth;


$router = new Router();

$router->get('/', eventController::class, 'home');
$router->get('/event', eventController::class, 'event');
$router->get('/event', eventController::class, 'readAll');
$router->post('/create-event', eventController::class, 'create');
// affichage du dashboard pour l'admin
$router->get('/dashboard', dashboardController::class, 'index');
//categorie paths
$router->get('/categories', categorieController::class, 'index');
$router->post('/addcategorie', categorieController::class, 'addCategory');
$router->get('/deleteCategorie', categorieController::class, 'deleteCategorie');
$router->post('/updateCategorie', categorieController::class, 'updateCategorie');
// events accept / refuse
$router->get('/admin/events', eventController::class, 'getEvents');
$router->get('/refuse-event', eventController::class, 'refuseEvent');
$router->get('/accept-event', eventController::class, 'acceptEvent');
// login
$router->get('/login', loginController::class, 'loginPage');
$router->get('/signup', signupController::class, 'signupPage');


$router->post('/login', loginController::class, 'login');
$router->post('/signup', signupController::class, 'signup');
$router->get('/logout', Auth::class, 'logout');

$router->dispatch();