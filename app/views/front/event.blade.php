<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event2 - Club Party</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="public/assets/js/script.js">
    <style>
        body.no-scroll {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100">

    <header class="bg-gray-900 text-white">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold">EVENT2</div>
            <div class="hidden md:flex space-x-8">
                <a href="#" class="hover:text-blue-400">Home</a>
                <a href="#" class="hover:text-blue-400">Event</a>
                <a href="#" class="hover:text-blue-400">Artist</a>
                <a href="#" class="hover:text-blue-400">Media</a>
                <a href="#" class="hover:text-blue-400">News</a>
                <a href="#" class="hover:text-blue-400">Shop</a>
                <a href="#" class="hover:text-blue-400">Contact</a>
                <a href="#" class="hover:text-blue-400">Timetable</a>
            </div>
        </nav>

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

    <main class="container mx-auto my-12 px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Events</h2>
            <button onclick="openForm()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Create
            </button>
        </div>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Ville</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Catégorie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Prix</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Lien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Couverture</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date Fin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nombre de Places</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($events as $event)
                        <tr>
                            <td class="px-6 py-4">{{ $event['titre'] }}</td>
                            <td class="px-6 py-4">{{ $event['type'] }}</td>
                            <td class="px-6 py-4">{{ $event['id_ville'] }}</td>
                            <td class="px-6 py-4">{{ $event['id_user'] }}</td>
                            <td class="px-6 py-4">{{ $event['id_categorie'] }}</td>
                            <td class="px-6 py-4">{{ $event['prix'] }} €</td>
                            <td class="px-6 py-4">
                                @if ($event['lien'])
                                    <a href="{{ $event['lien'] }}" class="text-blue-500">Voir</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ 'images/' . $event['couverture'] }}" alt="Couverture" style="width: 100%" class="w-16 h-16 object-cover">
                            </td>
                            <td class="px-6 py-4">{{ $event['date_event'] }}</td>
                            <td class="px-6 py-4">{{ $event['date_fin'] }}</td>
                            <td class="px-6 py-4">{{ $event['nombre_place'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    </main>
    <div id="formPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="bg-white p-8 rounded-lg w-full max-w-2xl">
                <h2 class="text-2xl font-bold mb-6">Create New Event</h2>
                <form id="eventForm" method="POST" action="/create-event" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Titre</label>
                            <input type="text" name="titre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                <option value="">--Please choose a type--</option>
                                <option value="free">Free</option>
                                <option value="payant">Payant</option>
                            </select>
                        </div>

                        <div id="prixField" class="hidden">
                            <label class="block text-sm font-medium text-gray-700">Prix</label>
                            <input type="number" name="prix" step="0.01" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event type</label>
                            <select name="event_type" id="event_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                <option value="">--Please choose a event type--</option>
                                <option value="live">Live</option>
                                <option value="presentiel">Presentiel</option>
                            </select>
                        </div>

                        <div id="lienField" class="hidden">
                            <label class="block text-sm font-medium text-gray-700">Lien</label>
                            <input type="url" name="lien" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div id="localisationField" class="hidden">
                            <label class="block text-sm font-medium text-gray-700">Localisation</label>
                            <input type="text" name="localisation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ville</label>
                            <select name="ville_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                <option value="">Sélectionner une ville</option>
                                <?php foreach ($villes as $ville): ?>
                                    <option value="<?= $ville['id'] ?>"><?= $ville['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <input type="text" name="categorie" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Couverture</label>
                            <input type="file" name="couverture" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>              

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Event</label>
                            <input type="date" name="date_event" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Fin</label>
                            <input type="date" name="date_fin" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre de Places</label>
                            <input type="number" name="nombre_place" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" onclick="closeForm()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Annuler</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Sponsors</h2>
        <button onclick="openForms()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
            Add Sponsor
        </button>
    </div>

    <!-- Sponsor Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Logo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($sponsors as $sponsor)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $sponsor['name'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ 'images/' . $sponsor['logo'] }}" alt="Sponsor Logo" class="h-10 w-10 rounded-full">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <form action="/event" method="GET" class="inline-block">
                                <input type="hidden" name="id" value="{{ $sponsor['id'] }}">
                                <button type="button" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700"  
                                    onclick="openFormUpdate();">
                                    Update
                                </button>
                            </form>
                            <a href="/delete-sponsor?id={{ $sponsor['id'] }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this sponsor?');">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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


    {{-- form update --}}
    <div id="updateForm" class="fixed inset-0 bg-black bg-opacity-50 hidden backdrop-blur-sm overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="bg-white p-8 rounded-lg w-full max-w-2xl">
                <h2 class="text-2xl font-bold mb-6">Update Sponsor</h2>
                <form method="POST" action="/event" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $sponsorById['id'] }}">
    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input value="{{ $sponsorById['name'] }}" type="text" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                    </div>
    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Logo</label>
                        <div class="mb-2">
                            @if($sponsorById['logo']) 
                                <img src="{{ $sponsorById['logo'] }}" alt="Current Logo" class="w-32 h-32 object-cover">
                            @endif
                        </div>
                        <input type="file" name="logo" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
    
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" onclick="closeFormUpdate()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    

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

    <script>
        function openForm() {
            document.getElementById('formPopup').classList.remove('hidden');
            document.body.classList.add('no-scroll'); 
        }

        function closeForm() {
            document.getElementById('formPopup').classList.add('hidden');
            document.body.classList.remove('no-scroll'); 
        }

        const typeDropdown = document.getElementById('type');
        const eventTypeDropdown = document.getElementById('event_type');
        const prixField = document.getElementById('prixField');
        const localisationField = document.getElementById('localisationField');
        const lienField = document.getElementById('lienField');

        typeDropdown.addEventListener('change', togglePrixField);
        eventTypeDropdown.addEventListener('change', toggleEventTypeFields);

        function togglePrixField() {
            if (typeDropdown.value === 'payant') {
                prixField.classList.remove('hidden'); 
            } else {
                prixField.classList.add('hidden');
            }
        }

        function toggleEventTypeFields() {
            if (eventTypeDropdown.value === 'live') {
                lienField.classList.remove('hidden'); 
                localisationField.classList.add('hidden');
            } else if (eventTypeDropdown.value === 'presentiel') {
                localisationField.classList.remove('hidden');
                lienField.classList.add('hidden'); 
            } else {
                localisationField.classList.add('hidden');
                lienField.classList.add('hidden');
            }
        }

        function openForms() {
            document.getElementById('formPopups').classList.remove('hidden');
            document.body.classList.add('no-scroll');
        }

        function closeForms() {
            document.getElementById('formPopups').classList.add('hidden');
            document.body.classList.remove('no-scroll');
        }


        function openFormUpdate() {
            document.getElementById('updateForm').classList.remove('hidden');
            document.body.classList.add('no-scroll');
        }

        function closeFormUpdate() {
            document.getElementById('updateForm').classList.add('hidden');
            document.body.classList.remove('no-scroll');
        }

    </script>
</body>
</html>