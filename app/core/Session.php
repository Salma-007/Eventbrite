<?php
namespace App\core;

class Session {
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public function isLogging(){
        return isset($_SESSION['user_id']);
    }
   
    public function destroy() {
        session_unset();  
        session_destroy(); 
    }

   
}
