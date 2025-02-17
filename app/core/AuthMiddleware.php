<?php 
namespace App\core;
use App\config\Database;

class AuthMiddleware {
    public static function handle($role) {
        $session = new Session();
        if (!$session->isLogging()) {
            header('Location: /login');
            exit;
        }

        $db = Database::connect();
        $query = $db->prepare("SELECT id_role FROM roles_users WHERE id_user = ?");
        $query->execute([$session->get('user_id')]);
        $userRole = $query->fetch()['id_role'];

        if ($userRole != $role) {
            header('Location: /login');
            exit;
        }
    }
}