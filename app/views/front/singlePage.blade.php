@extends('front.layout')

@section('content')
<body class="bg-gradient-to-r from-yellow-500 to-orange-500 shadow-lg">

    <!-- Header -->
    <header>

    </header>

    <main class="flex flex-col md:flex-row items-center justify-between px-10 py-16 text-white">
        <section class="w-full md:w-1/2 flex justify-center mb-8 md:mb-0 animate-fadeIn">
            <img src="../../../images/<?= htmlspecialchars($eventById['couverture']) ?>" alt="Event Image" class="rounded-lg shadow-2xl w-full max-w-md transform transition duration-500 hover:scale-105 hover-glow">
        </section>
    
        <section class="w-full md:w-1/2 mb-8 md:mb-0 animate-fadeIn">
            <h2 class="text-5xl font-bold text-yellow-400 mb-4">Timetable</h2>
            <p class="text-gray-300 mt-4 text-lg">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </section>
    
        <section class="w-full md:w-1/2 animate-fadeIn">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg hover:bg-gray-700 transition duration-300">
                    <h2 class="text-3xl font-semibold text-yellow-400 mb-6">Détails de l'événement</h2>
                    <ul class="space-y-3 text-gray-300">
                        <li><strong class="text-yellow-400">Date :</strong> <?= date("d M Y - H:i", strtotime($eventById['date_event'])) ?></li>
                        <li><strong class="text-yellow-400">Fin :</strong> <?= date("d M Y - H:i", strtotime($eventById['date_fin'])) ?></li>
                        <li><strong class="text-yellow-400">Places disponibles :</strong> <?= htmlspecialchars($eventById['nombre_place']) ?></li>
                        <li><strong class="text-yellow-400">Mode :</strong> <?= htmlspecialchars($eventById['event_type']) ?></li>
                        <li><strong class="text-yellow-400">Adresse :</strong> <?= htmlspecialchars($eventById['adresse'] ?: 'Non spécifiée') ?></li>
                        <li><strong class="text-yellow-400">Sponsors :</strong> <?= htmlspecialchars($eventById['sponsors']) ?></li>
                    </ul>
                </div>
    
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg hover:bg-gray-700 transition duration-300">
                    <h2 class="text-3xl font-semibold text-yellow-400 mb-6">Description</h2>
                    <p class="text-gray-300"><?= htmlspecialchars($eventById['description']) ?></p>
                    <p class="text-lg font-semibold text-green-400 mt-4">Prix : <?= ($eventById['prix'] > 0) ? $eventById['prix'] . " MAD" : "Gratuit" ?></p>
                </div>
            </div>
    
            <div class="flex justify-center mt-8 space-x-6">
                <a href="reservation.php?id=<?= $eventById['id'] ?>" class="bg-green-500 text-white px-8 py-3 rounded-lg text-lg hover:bg-green-600 transition duration-300 shadow-md transform hover:scale-110 hover-glow">Réserver</a>
                <a href="/" class="bg-gray-500 text-white px-8 py-3 rounded-lg text-lg hover:bg-gray-600 transition duration-300 shadow-md transform hover:scale-110 hover-glow">Retour</a>
            </div>
        </section>
    </main>
@endsection
    

