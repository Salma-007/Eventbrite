@extends('front.layout')

@section('content')
<div class="container mx-auto my-12 px-4">
    <h1 class="text-4xl font-bold text-center mb-8">Mes Réservations</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($reservations as $reservation)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden group hover:scale-105 transition-transform duration-500">
                <div class="relative">
                    <img src="../../../images/{{ $reservation['couverture'] }}" alt="Event Image" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                    <a href="/single-page?id={{ $reservation['id_event'] }}" class="absolute top-3 left-3 bg-white text-yellow-500 px-3 py-1 rounded-full">View</a>
                    <span class="absolute bottom-3 right-3 bg-yellow-500 text-white px-3 py-1 rounded-full">
                        {{ $reservation['type'] === 'payant' ? '$' . number_format($reservation['prix'], 2) : 'Gratuit' }}
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold transition-all duration-500 group-hover:translate-y-2">{{ $reservation['titre'] }}</h3>
                    <div class="flex items-center gap-2 text-gray-600 mt-2">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">{{ $reservation['event_type'] }}</span>
                        <span>📅 {{ date('F j, Y', strtotime($reservation['date_event'])) }}</span>
                        <span>📍 {{ $reservation['adresse'] }}</span>
                    </div>
                    <p class="text-gray-600 mt-3">{{ substr($reservation['description'], 0, 100) }}...</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
