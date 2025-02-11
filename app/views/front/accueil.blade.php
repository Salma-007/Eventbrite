<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Choix de rôle</title>
    <link rel="stylesheet" href="/assets/css/login-Style.css">
</head>
<body>

<nav class="navbar">
        <div class="navbar-container">
            <a href="/logout" class="navbar-link">Logout</a>
        </div>
    </nav>
    <?php
                session_start();
                if (isset($_SESSION['user_id'])) {
                    echo "Bienvenue, " . htmlspecialchars($_SESSION['user_name']) . "!";
                } else {
                    echo "Bienvenue, invité!";
                }
                ?>
  
    <section>
        <div class="bg-container">
            <img src="/assets/img/login-register/bg.jpg" class="bg">
            <img src="/assets/img/login-register/trees.png" class="trees">
        </div>

        <div class="role-selection">
            <h2>Choisissez votre rôle</h2>
            <div class="role-buttons">
            <form action="/choisir-role" method="POST">
                <div class="role-buttons">
                    <button type="submit" name="role" value="organisateur">Organisateur</button>
                    <button type="submit" name="role" value="participant">Participant</button>
                </div>
            </form>
            </div>
        </div>
    </section>

   
</body>
</html>
