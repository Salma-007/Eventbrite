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

document.getElementById('search-btn').addEventListener('click', function() {
var searchValue = document.getElementById('search-input').value.trim();

if (searchValue) {
    fetch(`/search-event?title=${searchValue}`, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        updateEventList(data.eventSearch); 
    })
    .catch(error => {
        console.error('Error during search:', error);
    });
} else {
    fetch('/search-event', {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        updateEventList(data.events); 
    })
    .catch(error => {
        console.error('Error fetching all events:', error);
    });
}
});

function updateEventList(events) {
let eventListContainer = document.getElementById('event-list'); 
eventListContainer.innerHTML = ''; 

if (events.length > 0) {
    events.forEach(event => {
        let eventElement = document.createElement('div');
        eventElement.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'overflow-hidden', 'group', 'hover:scale-105', 'transition-transform', 'duration-500');
        
        eventElement.innerHTML = `
            <div class="relative">
                <img src="../../../images/${event.couverture}" alt="Event Image" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                <a href="/single-page?id=${event.id}" class="absolute top-3 left-3 bg-white text-yellow-500 px-3 py-1 rounded-full">View</a>
                <span class="absolute bottom-3 right-3 bg-yellow-500 text-white px-3 py-1 rounded-full">
                    ${event.type === 'payant' ? '$' + event.prix.toFixed(2) : 'Gratuit'}
                </span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold transition-all duration-500 group-hover:translate-y-2">${event.titre}</h3>
                <div class="flex items-center gap-2 text-gray-600 mt-2">
                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                        ${event.event_type}
                    </span>
                    <span>📅 ${new Date(event.date_event).toLocaleDateString()}</span>
                    <span>📍 ${event.adresse}</span>
                </div>
                <p class="text-gray-600 mt-3">${event.description.slice(0, 100)}...</p>
                <div class="flex justify-end items-center gap-4 mt-4">
                    <button class="text-gray-600 hover:text-blue-500 text-xl">
                        <i class="fas fa-thumbs-up"></i> ${event.likes}
                    </button>
                    <button class="text-gray-600 hover:text-red-500 text-xl">
                        <i class="fas fa-thumbs-down"></i> ${event.dislikes}
                    </button>
                </div>
            </div>
        `;
        
        eventListContainer.appendChild(eventElement);
    });
} else {
    eventListContainer.innerHTML = `<p class="text-center text-gray-600 w-full">No events found matching your search.</p>`;
}
}