<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventChamp Conference</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
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
<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-red-900">
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
                    <img src="https://source.unsplash.com/1600x900/?mountain" class="w-full h-screen object-cover">
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
                    <img src="https://source.unsplash.com/1600x900/?concert" class="w-full h-screen object-cover">
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

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>
    </header>



    <main class="container mx-auto my-12 px-4">
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">About the Event</h2>
            <p class="text-gray-600 leading-relaxed">
                The EventChamp Conference is a premier event bringing together industry leaders, innovators, and enthusiasts from around the world. Join us for insightful talks, networking opportunities, and much more.
            </p>
        </section>

        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Featured Speakers</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-blue-600">Speaker One</h3>
                    <p class="text-gray-600 mt-2">CEO of Company One</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-blue-600">Speaker Two</h3>
                    <p class="text-gray-600 mt-2">CTO of Company Two</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-blue-600">Speaker Three</h3>
                    <p class="text-gray-600 mt-2">Founder of Company Three</p>
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
    </script>

</body>
</html>