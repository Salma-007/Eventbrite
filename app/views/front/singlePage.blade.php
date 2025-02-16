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
    
                <!-- Section pour les boutons de réservation -->
                <div class="flex justify-center mt-8 space-x-6">
                <?php if ($eventById['prix'] > 0): ?>
                    <form action="/reservation/create" method="POST">
                        <input type="hidden" name="type" value="payant">
                    <button onclick="openPaymentModal(<?= htmlspecialchars($eventById['id']) ?>, <?= htmlspecialchars($eventById['prix']) ?>)" class="bg-green-500 text-white px-8 py-3 rounded-lg text-lg hover:bg-green-600 transition duration-300 shadow-md transform hover:scale-110 hover-glow">
                        Réserver et Payer avec PayPal
                    </button>
                    </form>
                <?php else: ?>
                    <form id="freeReservationForm" action="/reservation/create" method="POST">
                        <input type="hidden" name="event_id" value="<?= htmlspecialchars($eventById['id']) ?>">
                        <input type="hidden" name="type" value="free">
                        <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-lg text-lg hover:bg-blue-600 transition duration-300 shadow-md transform hover:scale-110 hover-glow">
                            Réserver gratuitement
                        </button>
                    </form>
                <?php endif; ?>
                <a href="/" class="bg-gray-500 text-white px-8 py-3 rounded-lg text-lg hover:bg-gray-600 transition duration-300 shadow-md transform hover:scale-110 hover-glow">Retour</a>
            </div>
        </section>
    </main>
 
   <!-- Modal de sélection du nombre de places -->
 
  <!-- Modal de paiement PayPal -->
  <div id="paymentModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Paiement PayPal</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-lg text-gray-700">Nombre de places : <span id="selectedQuantity">1</span></p>
            <p class="text-lg font-bold text-green-500">Total : <span id="totalPrice"><?= $eventById['prix'] ?></span> MAD</p>
            <div id="paypal-button-container"></div>
        </div>
    </div>

</body>
@endsection

    
@section('scripts')
<script>
function openPaymentModal(eventId, eventPrice) {
    console.log('Opening payment modal for event ID:', eventId, 'Price:', eventPrice);
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('totalPrice').textContent = eventPrice.toFixed(2);

    if (!document.getElementById('paypal-button-container').innerHTML.trim()) {
        paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: eventPrice.toFixed(2)
                },
                custom_id: eventId // Passez l'ID de l'événement ici
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            console.log('Order captured:', details);
            alert('Paiement réussi !');
            window.location.href = '/payment/success';
        });
    }
}).render('#paypal-button-container');
    }
}
  function closeModal() {
      document.getElementById('paymentModal').classList.add('hidden');
  }
</script>
@endsection

