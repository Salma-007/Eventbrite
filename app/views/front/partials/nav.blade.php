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
        <a href="#" class="hover:text-yellow-400">Event</a>
        <a href="#" class="hover:text-yellow-400">Artist</a>
        <a href="#" class="hover:text-yellow-400">Media</a>
        <a href="#" class="hover:text-yellow-400">News</a>
        <a href="#" class="hover:text-yellow-400">Shop</a>
        <a href="#" class="hover:text-yellow-400">Contact</a>
        <a href="#" class="hover:text-yellow-400">Timetable</a>
    </div>
</nav>