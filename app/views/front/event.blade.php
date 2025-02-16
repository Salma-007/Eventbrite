@extends('front.layout')

@section('content')

    <header class="bg-gray-900 text-white">
        

        <div class="container mx-auto px-6 py-20 text-center">
            <h1 class="text-5xl font-bold mb-4">CLUB PARTY</h1>
            <p class="text-lg text-gray-300 mb-6">
                It is a long established fact that a reader will fit in long TRAFFIC, the world's largest WHERE trade monitoring.
            </p>
            <p class="text-lg text-gray-300">
                The second single to be taken from Coldplay's...
            </p>
        </div>
    </header>
    <main>
        <section class="container mx-auto my-12 px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Events</h2>
                <button onclick="openForm()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Create
                </button>
            </div>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="{{ 'images/' . $event['couverture'] }}" alt="Event Cover" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $event['titre'] }}</h3>
                            <p class="text-gray-600 mb-2"><span class="font-medium">Type:</span> {{ $event['type'] }}</p>
                            <p class="text-gray-600 mb-2"><span class="font-medium">City:</span> {{ $event['ville'] }}</p>
                            <p class="text-gray-600 mb-2"><span class="font-medium">Category:</span> {{ $event['categorie'] }}</p>
                            <p class="text-gray-600 mb-2"><span class="font-medium">Price:</span> {{ $event['prix'] }} €</p>
                            <p class="text-gray-600 mb-2"><span class="font-medium">Date:</span> {{ $event['date_event'] }}</p>
                            <p class="text-gray-600 mb-4"><span class="font-medium">Places:</span> {{ $event['nombre_place'] }}</p>
                            <div class="flex space-x-4">
                                <a href="/edit-event?id={{ $event['id'] }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-300">
                                    Update
                                </a>
                                <a href="/delete-event?id={{ $event['id'] }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300" onclick="return confirm('Are you sure you want to delete this event?');">
                                    Delete
                                </a>
                                <a href="/participants-event?id={{ $event['id'] }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300">
                                    participants
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <div id="formPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden backdrop-blur-sm overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white p-8 rounded-lg w-full max-w-2xl">
                    <h2 class="text-2xl font-bold mb-6">Create New Event</h2>
                    <form id="eventForm" method="POST" action="/create-event" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                                <input placeholder="Entrer votre titre" type="text" name="titre" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">--Please choose a type--</option>
                                    <option value="free">Free</option>
                                    <option value="payant">Payant</option>
                                </select>
                            </div>
        
                            <div id="prixField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                                <input placeholder="Entrer votre prix"  type="number" name="prix" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Event type</label>
                                <select name="event_type" id="event_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">--Please choose an event type--</option>
                                    <option value="live">Live</option>
                                    <option value="presentiel">Presentiel</option>
                                </select>
                            </div>
        
                            <div id="lienField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lien</label>
                                <input placeholder="Entrer votre lien"  type="url" name="lien" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div id="localisationField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                <input placeholder="Entrer votre adresse"  type="text" name="adresse" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                                <select id="region-select" name="region_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">Sélectionner une region</option>
                                    <?php foreach ($regions as $region): ?>
                                        <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                                <select id="ville-select" name="ville_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">Sélectionner une ville</option>
                                    <?php foreach ($villes as $ville): ?>
                                        <option value="<?= $ville['id'] ?>"><?= $ville['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                                <select name="id_categorie" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="">Sélectionner une categorie</option>
                                    <?php foreach ($categories as $categorie): ?>
                                        <option value="<?= $categorie['id'] ?>"><?= $categorie['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Couverture</label>
                                <input type="file" name="couverture" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date Event</label>
                                <input type="datetime-local" name="date_event" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date Fin</label>
                                <input type="datetime-local" name="date_fin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de Places</label>
                                <input placeholder="Entrer votre places"  type="number" name="nombre_place" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
        
                            <div class="col-span-full">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea placeholder="Entrer votre description"  name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" rows="4"></textarea>
                            </div>
        
                            <div class="col-span-full">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sponsors</label>
                                <select id="sponsors" name="sponsors[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" multiple>
                                    <?php foreach ($sponsors as $sponsor): ?>
                                        <option value="<?php echo htmlspecialchars($sponsor['id']); ?>">
                                            <?php echo htmlspecialchars($sponsor['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
        
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" onclick="closeForm()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200">Annuler</button>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mb-6 p-5">
            <h2 class="text-3xl font-bold text-gray-800">Sponsors</h2>
            <button onclick="openForms()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Add Sponsor
            </button>
        </div>
    
    
        <!-- Sponsor Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-3 p-5">
            @foreach ($sponsors as $sponsor)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ '/sponsors/' . $sponsor['logo'] }}" alt="Sponsor Logo" class="h-16 w-16 rounded-full object-cover">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $sponsor['name'] }}</h3>
                        </div>
                        <div class="mt-4 flex space-x-4">
                            <a href="/editEvent?id={{ $sponsor['id'] }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-300">
                                Update
                            </a>
                            <a href="/delete-sponsor?id={{ $sponsor['id'] }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300" onclick="return confirm('Are you sure you want to delete this sponsor?');">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        

        <div id="formPopups" class="fixed inset-0 bg-black bg-opacity-50 hidden backdrop-blur-sm overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white p-8 rounded-lg w-full max-w-2xl">
                    <h2 class="text-2xl font-bold mb-6">Add Sponsor</h2>
                    <form id="sponsorForm" method="POST"  action="/create-sponsor" enctype="multipart/form-data">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Logo</label>
                            <input type="file" name="logo" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" onclick="closeForms()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection