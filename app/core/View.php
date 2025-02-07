<?php

namespace App\core;

class View{

    public static function redirect($view){
        header('Location: '.$view);
    }
}