<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 1s ease-out;
        }
        .hover-glow:hover {
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.7));
        }
    </style>
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
    <style>
        body.no-scroll {
            overflow: hidden;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <header class="bg-yellow-500">
        @include('front.partials.nav')
    </header>

    <main class="main-content position-relative border-radius-lg">
    @yield('content')

  </main>

  <script src="../../../assets/js/script.js"></script>
  @include('front.partials.footer')
  @yield('scripts')
  
</body>
</html>