<?php

namespace App\core;

class Security
{
    
     // Nettoie les données d'entrée pour éviter les attaques XSS.
   
    
    public static function sanitizeInput($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    // Valide une adresse email.
    
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    
     // Valide un mot de passe.
     // - Doit contenir au moins 8 caractères.
      //- Doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.
    public static function validatePassword($password)
    {
        return preg_match('/^(?=.*\d).{3,}$/', $password);
    }

    // Vérifie si deux mots de passe correspondent

    public static function confirmPassword($password, $confirmPassword)
    {
        return $password === $confirmPassword;
    }

    // Hash un mot de passe.
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // Vérifie si un mot de passe correspond à un hash
     
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}