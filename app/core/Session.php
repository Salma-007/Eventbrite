<?php
namespace App\core;

class Session {
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function isLogging(){
        return isset($_SESSION['user_id']);
    }
   
    public function destroy() {
        session_unset();  
        session_destroy(); 
    }

   
}
