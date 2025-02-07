<?php
namespace App\core;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller {
    protected $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../views/front'); 
        $this->twig = new Environment($loader, [
            'cache' => false, 
            'debug' => true,
        ]);
    }

    public function render($view, $data = []) {
        echo $this->twig->render("$view.twig", $data);
    }
}
