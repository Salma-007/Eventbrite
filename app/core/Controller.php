<?php
namespace App\core;

use Jenssegers\Blade\Blade;

class Controller {
    protected $blade;

    public function __construct() {
        $views = __DIR__ . '/../views/back';  
        $cache = __DIR__ . '/../cache';       

        $this->blade = new Blade($views, $cache);
    }

    public function render($view, $data = []) {
        echo $this->blade->render($view, $data);
    }
}
