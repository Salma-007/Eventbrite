<?php
namespace App\controllers\front;

use App\Models\PdfGenerator;
use App\core\Controller;
use App\models\User;
use App\core\View;
use App\core\Security;

class UserController extends Controller {
    protected $userModel;
    private $user;
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->user = new User();
        
    }

    public function exportPDF() {
        $id_event = $_GET['id'];
        $participants = $this->user->getUsersEvent($id_event);

        $pdf = new PdfGenerator();
        $pdf->AddPage();
        
        $header = ['Nom', 'Email'];
        $pdf->generateTable($header, $participants);
        
        $pdf->Output('D', 'participants.pdf');
        // header("location: /event");
    }


    public function homePage() {
        $isLoggedIn = $this->session->isLoggedIn();
        View::render('home', ['isLoggedIn' => $isLoggedIn]);   
     }
    

}
