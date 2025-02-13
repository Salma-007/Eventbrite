<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventChamp Conference</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .swiper {
            width: 100%;
            height: 92vh;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

    </style>
</head>
<body>

    <!-- Header -->
    <header class="bg-yellow-500">
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

        <!-- Slider Section -->
        <div class="swiper relative">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide relative">
                    <img src="../../../images/Heisen2.jpg" class="w-full h-screen object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center">
                        <span class="bg-yellow-500 text-black px-4 py-1 rounded-full">TRAVEL</span>
                        <h1 class="text-5xl font-bold mt-4">Table Mountain Cableway</h1>
                        <p class="text-lg text-gray-300 mt-4">April 14, 2024 - Cape Town - Table Mountain</p>
                        <div class="mt-6 space-x-4">
                            <button class="px-6 py-2 border border-white text-white rounded-lg hover:bg-white hover:text-black transition">DETAILS</button>
                            <button class="px-6 py-2 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition">BUY TICKET</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide relative">
                    <img src="../../../images/1741843.jpg" class="w-full h-screen object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center">
                        <span class="bg-yellow-500 text-black px-4 py-1 rounded-full">MUSIC</span>
                        <h1 class="text-5xl font-bold mt-4">Live Concert 2025</h1>
                        <p class="text-lg text-gray-300 mt-4">May 20, 2025 - Paris - Grand Arena</p>
                        <div class="mt-6 space-x-4">
                            <button class="px-6 py-2 border border-white text-white rounded-lg hover:bg-white hover:text-black transition">DETAILS</button>
                            <button class="px-6 py-2 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition">BUY TICKET</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>
    </header>

    <main class="container mx-auto my-12 px-4">
        <section class="mb-12 bg-gray-100 p-6 rounded-lg shadow">
            <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
                <input type="text" placeholder="e.g. event, meetup" class="w-full p-2 border border-gray-300 rounded-md">
                <select class="w-full p-2 border border-gray-300 rounded-md">
                    <option>Category</option>
                    <option>Music</option>
                    <option>Sports</option>
                    <option>Technology</option>
                </select>
                <select class="w-full p-2 border border-gray-300 rounded-md">
                    <option>Location</option>
                    <option>New York</option>
                    <option>London</option>
                    <option>Tokyo</option>
                </select>
                <select class="w-full p-2 border border-gray-300 rounded-md">
                    <option>Organizer</option>
                    <option>EventPro</option>
                    <option>MusicFest</option>
                </select>
                <input type="date" class="w-full p-2 border border-gray-300 rounded-md">
                <button class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-400 transition">SEARCH</button>
            </div>
        </section>

        <section class="mb-12">
            <h2 class="text-4xl font-bold text-center mb-8">Upcoming <span class="text-yellow-500">Events</span></h2>
    
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
            </div>
        </section>

        <section class="container mx-auto my-12 px-4">
            <div class="flex flex-wrap gap-4 justify-center mb-8">
                <button class="bg-yellow-500 text-white px-4 py-2 rounded-full">ALL</button>
                <?php foreach ($categories as $category) : ?>
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded-full">
                        <?= htmlspecialchars($category['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($events as $event) : ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden group hover:scale-105 transition-transform duration-500">
                        <div class="relative">
                            <img src="../../../images/<?= htmlspecialchars($event['couverture']) ?>" alt="Event Image" 
                                class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                            <a href="/single-page?id={{ $event['id'] }}" class="absolute top-3 left-3 bg-white text-yellow-500 px-3 py-1 rounded-full">View</a>
                            <span class="absolute bottom-3 right-3 bg-yellow-500 text-white px-3 py-1 rounded-full">
                                <?= ($event['type'] === 'payant') ? '$' . number_format($event['prix'], 2) : 'Gratuit' ?>
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold transition-all duration-500 group-hover:translate-y-2"><?= htmlspecialchars($event['titre']) ?></h3>
                            <div class="flex items-center gap-2 text-gray-600 mt-2">
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                                    <?= htmlspecialchars($event['event_type']) ?>
                                </span>
                                <span>📅 <?= date('F j, Y', strtotime($event['date_event'])) ?></span>
                                <span>📍 <?= htmlspecialchars($event['adresse']) ?></span>
                            </div>
                            <p class="text-gray-600 mt-3"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
            
                            <!-- Like & Dislike Icons -->
                            <div class="flex justify-end items-center gap-4 mt-4">
                                <button class="text-gray-600 hover:text-blue-500 text-xl">
                                    <i class="fas fa-thumbs-up"></i> <?= $event['likes'] ?>
                                </button>
                                <button class="text-gray-600 hover:text-red-500 text-xl">
                                    <i class="fas fa-thumbs-down"></i> <?= $event['dislikes'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>            
        </section>

        <section class="mb-12">
            <h2 class="text-4xl font-bold text-center mb-8">Kings <span class="text-yellow-500">Sponsors</span></h2>
    
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
            </div>
        </section>
        <section class="py-12 bg-gray-100">
            <div class="swiper-container relative overflow-hidden">
                <div class="swiper-wrapper flex">
                    <?php foreach ($sponsors as $sponsor) : ?>
                        <div class="swiper-slide flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4 h-[400px] bg-white rounded-lg shadow-lg flex flex-col justify-between relative" 
                            style="background-image: url('../../../images/<?= htmlspecialchars($sponsor['logo']) ?>'); background-size: cover; background-position: center;">
                            
                            <!-- Sponsor Name -->
                            <div class="absolute bottom-4 right-4 bg-black text-white text-sm px-3 py-1 rounded-full">
                                Sponsored by <?= htmlspecialchars($sponsor['name']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            
                <!-- Pagination -->
                <div class="swiper-pagination absolute bottom-0 left-0 right-0 p-4 text-center"></div>
            
                <!-- Navigation buttons -->
                <div class="swiper-button-next absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">
                    &#62;
                </div>
                <div class="swiper-button-prev absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">
                    &#60;
                </div> 
            </div> 
        </section>
        
        <section class="w-full min-h-[70vh] bg-yellow-400 flex items-center justify-center py-4 md:py-8 border-4 border-yellow-500 rounded-2xl shadow-lg" id="contact">
            <div class="container mx-auto px-4 py-4 md:py-8">
                <div class="text-center text-gray-900 mb-4">
                    <h2 class="text-4xl font-extrabold mb-2">If You Have Any Question</h2>
                    <p class="text-lg">You Can Contact Us</p>
                </div>
        
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-gray-900 max-w-lg mb-4 md:mb-0">
                        <h2 class="text-3xl font-extrabold leading-tight mb-2">Contactez-Nous</h2>
                        <p class="text-lg mb-2">Envoyez-nous un message et nous vous répondrons rapidement.</p>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-2xl w-full md:w-1/2">
                        <form action="#" method="POST" class="space-y-4">
                            <div class="relative">
                                <label for="email" class="block text-gray-800 font-semibold mb-1">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-5 py-2.5 text-lg rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-300 ease-in-out bg-white text-gray-900 placeholder-gray-400 shadow-md placeholder-opacity-75">
                            </div>
        
                            <div class="relative">
                                <label for="message" class="block text-gray-800 font-semibold mb-1">Message</label>
                                <textarea id="message" name="message" required rows="3"
                                    class="w-full px-5 py-2.5 text-lg rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-300 ease-in-out bg-white text-gray-900 placeholder-gray-400 shadow-md placeholder-opacity-75"></textarea>
                            </div>
        
                            <button type="submit"
                                class="w-full py-2.5 px-4 bg-yellow-600 text-white font-semibold rounded-lg transform hover:scale-105 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-300 ease-in-out">
                                Envoyer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>


        <section class="w-full bg-gray-100 py-12">
            <div class="container mx-auto px-4">
                <section class="mb-12">
                    <h2 class="text-4xl font-bold text-center mb-8">Explore <span class="text-yellow-500">Our Cities</span></h2>
        
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    </div>
                </section>
        
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
                    <!-- City 1 -->
                    <div class="relative h-64 rounded-xl overflow-hidden shadow-lg group">
                        <img src="../../../images/e897d78c3ed91579bd1817d6cac8b023.jpg" alt="Paris" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity duration-500 group-hover:bg-opacity-40"></div>
                        <h3 class="absolute bottom-4 left-4 text-white text-2xl font-bold transition-all duration-500 group-hover:translate-y-2">Marrakech</h3>
                    </div>
        
                    <!-- City 2 -->
                    <div class="relative h-64 rounded-xl overflow-hidden shadow-lg group">
                        <img src="../../../images/bc840999b95ca66d9990c31afd9a6a50.jpg" alt="New York" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity duration-500 group-hover:bg-opacity-40"></div>
                        <h3 class="absolute bottom-4 left-4 text-white text-2xl font-bold transition-all duration-500 group-hover:translate-y-2">Casablanca</h3>
                    </div>
        
                    <!-- City 3 -->
                    <div class="relative h-64 rounded-xl overflow-hidden shadow-lg group">
                        <img src="../../../images/f7b14cdc316b9909d41e25850da0426b.jpg" alt="Tokyo" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity duration-500 group-hover:bg-opacity-40"></div>
                        <h3 class="absolute bottom-4 left-4 text-white text-2xl font-bold transition-all duration-500 group-hover:translate-y-2">Tangier</h3>
                    </div>
                </div>
            </div>
        </section>
        
        
        
        
    </main>
    

    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">EVENTA</h3>
                    <p class="text-gray-400">EXUB PARTY</p>
                    <p class="text-gray-400 mt-2">Ricone and spaces</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Why choose NCCC</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Technology</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Exhibiting</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Media centre</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Privacy & disclaimer</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="text-gray-400 space-y-2">
                        <li>Phone: (033) 205-35-78</li>
                        <li>Email: info@beauthemac.com</li>
                        <li>Address: Creative Events Agency - London</li>
                        <li>[New York] Los Angeles</li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <ul class="text-gray-400 space-y-2">
                        <li><a href="#" class="hover:text-blue-400">Facebook</a></li>
                        <li><a href="#" class="hover:text-blue-400">Twitter</a></li>
                        <li><a href="#" class="hover:text-blue-400">Instagram</a></li>
                        <li><a href="#" class="hover:text-blue-400">LinkedIn</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">© 2018 Beauthemac. All rights reserved.</p>
            </div>
        </div>
    </footer>

    

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var destinationSwiper = new Swiper('.swiper-container', {
                slidesPerView: 3,  
                spaceBetween: 20,  
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                autoplay: {
                    delay: 1000,  
                    disableOnInteraction: false,
                },
                speed: 1000,  
                loop: true,  
            });
        });



        



        


    </script>

</body>
</html>