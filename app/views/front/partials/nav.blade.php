<nav class="container mx-auto px-6 py-4 flex justify-between items-center">
    <div class="text-xl font-bold"> 
        <?php
        if (isset($_SESSION['user_id'])) {
            echo htmlspecialchars($_SESSION['user_name']) . "!";
        } else {
            echo "Bienvenue, invité!";
        }
        ?>
    </div>
    <div class="hidden md:flex space-x-8">
        <a href="#" class="hover:text-yellow-400">Home</a>
    
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['user_role'] === 2): ?>
                <a href="/event" class="hover:text-yellow-400">Event</a>
                <a href="/accueil" class="hover:text-yellow-400">Switch Role</a>
                <a href="#" class="hover:text-yellow-400">Login</a>
                <a href="/logout" class="hover:text-yellow-400">Logout</a>
                <a href="/signup" class="hover:text-yellow-400">Signup</a>
            <?php elseif ($_SESSION['user_role'] === 3): ?>
                <a href="#" class="hover:text-yellow-400">Reservation</a>
                <a href="/accueil" class="hover:text-yellow-400">Switch Role</a>
                <a href="/logout" class="hover:text-yellow-400">Logout</a>
            <?php else: ?>
                <a href="/logout" class="hover:text-yellow-400">Logout</a>
            <?php endif; ?>
        
        <?php else: ?>
            <a href="/login" class="hover:text-yellow-400">Login</a>
            <a href="/signup" class="hover:text-yellow-400">Signup</a>
        <?php endif; ?>
    </div>
    
    
    
    
</nav>