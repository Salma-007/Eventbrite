<?php

use App\core\Router;
use App\controllers\front\eventController;
use App\controllers\front\userController;
use App\controllers\front\sponsorController;
use App\controllers\back\dashboardController;
use App\controllers\back\categorieController;
use App\controllers\back\loginController;
use App\controllers\back\signupController;
use App\controllers\front\accueilController;
use App\controllers\front\contactController;
use App\controllers\back\RoleController;
use App\controllers\back\PaymentController;
use App\controllers\back\ProfileController;
use App\controllers\back\ReservationController;
use App\controllers\front\UserReservationController;

use App\core\Auth;

use App\core\Session;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$router = new Router();

$router->get('/', eventController::class, 'home');
$router->get('/event', eventController::class, 'readAll');
$router->post('/create-event', eventController::class, 'create');
$router->get('/delete-event', eventController::class, 'delete');
$router->get('/edit-event', eventController::class, 'show');
$router->post('/update-event', eventController::class, 'update');
$router->get('/get_villes', eventController::class, 'VilleByRegion');
$router->get('/single-page', eventController::class, 'details');
// Route for searching events by title
$router->get('/search-event', eventController::class, 'searchEvent');
//pagination 
$router->get('/', EventController::class, 'listEvents');


// affichage du dashboard pour l'admin
$router->get('/dashboard', dashboardController::class, 'index');
// categorie paths
$router->get('/getCategories', categorieController::class, 'getCategories');
$router->get('/categories', categorieController::class, 'index');
$router->post('/addcategorie', categorieController::class, 'addCategory');
$router->get('/deleteCategorie', categorieController::class, 'deleteCategorie');
$router->post('/updateCategorie', categorieController::class, 'updateCategorie');
// sponsor paths
$router->post('/create-sponsor', sponsorController::class, 'addSponsor');
$router->get('/delete-sponsor', sponsorController::class, 'sponsorDelete');
$router->get('/editEvent', sponsorController::class, 'sponsorUpdateForm');
$router->post('/updateEvent', sponsorController::class, 'updateSponsor');
// events accept / refuse
$router->get('/admin/events', eventController::class, 'getEvents');
$router->get('/refuse-event', eventController::class, 'refuseEvent');
$router->get('/accept-event', eventController::class, 'acceptEvent');
// users manage for admin
$router->get('/admin/users', dashboardController::class, 'usersAdmin');
$router->get('/get-users', dashboardController::class, 'getUsers');
$router->get('/delete-user', dashboardController::class, 'deleteUser');
$router->get('/ban-user', dashboardController::class, 'banUser');
$router->get('/activate-user', dashboardController::class, 'activateUser');
// l'authentification 
$router->get('/login', loginController::class, 'loginPage');
$router->get('/signup', signupController::class, 'signupPage');
$router->post('/login', loginController::class, 'login');
$router->post('/signup', signupController::class, 'signup');
$router->get('/logout', Auth::class, 'logout');
$router->get('/accueil', accueilController::class, 'pageAccueil');
$router->post('/choisir-role', roleController::class, 'choisirRole');

//like and dislike
$router->get('/like-event', eventController::class, 'likeEvent');
$router->get('/dislike-event', eventController::class, 'dislikeEvent');

// voir profile
$router->get('/profile', ProfileController::class, 'voirProfile');
$router->post('/update-profile', ProfileController::class, 'updateProfile');

// contact us
$router->post('/contact/send', contactController::class , 'send');
// export pdf des participants
$router->get('/participants-event', userController::class , 'exportPDF');
$router->get('/mesReservations', UserReservationController::class, 'index');

// Routes pour la réservation et le paiement
$router->post('/reservation/create', ReservationController::class, 'reserveEvent'); // Réserver un événement
$router->get('/reservation/success', ReservationController::class, 'success'); // Succès de la réservation
$router->get('/reservation/failed', ReservationController::class, 'failed'); // Échec de la réservation

$router->get('/payment/payment', PaymentController::class, 'payment'); // Redirection vers PayPal
$router->get('/payment/success', PaymentController::class, 'success'); // Succès du paiement
$router->get('/payment/cancel', PaymentController::class, 'cancel'); // Annulation du paiement
$router->post('/payment/ipn', PaymentController::class, 'ipn'); // Notification instantanée de PayPal (IPN)
$router->dispatch();  