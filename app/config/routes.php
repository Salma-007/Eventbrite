<?php

use App\core\Router;
use App\controllers\front\eventController;
use App\controllers\front\UserController;
use App\controllers\back\dashboardController;
use App\controllers\back\categorieController;
use App\core\Auth;


$router = new Router();

$router->get('/', eventController::class, 'home');
$router->get('/event', eventController::class, 'event');
// affichage du dashboard pour l'admin
$router->get('/dashboard', dashboardController::class, 'index');
$router->get('/categories', categorieController::class, 'index');
$router->get('/login', userController::class, 'loginPage');
$router->get('/signup', userController::class, 'signupPage');


$router->post('/login', Auth::class, 'login');
$router->post('/signup', UserController::class, 'signup');
$router->get('/logout', Auth::class, 'logout');

$router->dispatch();