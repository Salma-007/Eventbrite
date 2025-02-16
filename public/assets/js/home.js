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

document.getElementById('search-btn').addEventListener('click', function() {
    let searchValue = document.getElementById('search-input').value.trim();
    let page = 1; 

    fetchEvents(searchValue, page);
});

function fetchEvents(title, page) {
    let url = `/search-event?title=${encodeURIComponent(title)}&page=${page}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            updateEventList(data.events);
            updatePagination(data.totalPages, data.currentPage, title);
        })
        .catch(error => {
            console.error('Error during search:', error);
        });
}

function updateEventList(events) {
    let eventContainer = document.getElementById('event-list');
    eventContainer.innerHTML = ''; 

    events.forEach(event => {
        let eventItem = document.createElement('div');
        eventItem.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'overflow-hidden', 'group', 'hover:scale-105', 'transition-transform', 'duration-500');

        eventItem.innerHTML = `
            <div class="relative">
                <img src="../../../images/${event.couverture}" alt="Event Image" 
                    class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                <a href="/single-page?id=${event.id}" class="absolute top-3 left-3 bg-white text-yellow-500 px-3 py-1 rounded-full">View</a>
                <span class="absolute bottom-3 right-3 bg-yellow-500 text-white px-3 py-1 rounded-full">
                    ${event.type === 'payant' ? '$' + parseFloat(event.prix).toFixed(2) : 'Gratuit'}
                </span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold transition-all duration-500 group-hover:translate-y-2">${event.titre}</h3>
                <div class="flex items-center gap-2 text-gray-600 mt-2">
                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                        ${event.event_type}
                    </span>
                    <span>📅 ${new Date(event.date_event).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })}</span>
                    <span>📍 ${event.adresse}</span>
                </div>
                <p class="text-gray-600 mt-3">${event.description.substring(0, 100)}...</p>
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

        eventContainer.appendChild(eventItem);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    function loadEvents(page) {
        fetch(`/?page=${page}&ajax=1`)
            .then(response => response.json())
            .then(data => {
                let eventList = document.getElementById("event-list");
                eventList.innerHTML = ""; 
                
                data.events.forEach(event => {
                    eventList.innerHTML += `
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden group hover:scale-105 transition-transform duration-500">
                            <div class="relative">
                                <img src="../../../images/${event.couverture}" alt="Event Image" 
                                    class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                                <a href="/single-page?id=${event.id}" class="absolute top-3 left-3 bg-white text-yellow-500 px-3 py-1 rounded-full">View</a>
                                <span class="absolute bottom-3 right-3 bg-yellow-500 text-white px-3 py-1 rounded-full">
                                    ${event.type === 'payant' ? '$' + parseFloat(event.prix).toFixed(2) : 'Gratuit'}
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
                                <p class="text-gray-600 mt-3">${event.description.substring(0, 100)}...</p>
                                <div class="flex justify-end items-center gap-4 mt-4">
                                    <button class="text-gray-600 hover:text-blue-500 text-xl">
                                        <i class="fas fa-thumbs-up"></i> ${event.likes}
                                    </button>
                                    <button class="text-gray-600 hover:text-red-500 text-xl">
                                        <i class="fas fa-thumbs-down"></i> ${event.dislikes}
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                let pagination = document.getElementById("pagination");
                pagination.innerHTML = "";
                for (let i = 1; i <= data.totalPages; i++) {
                    pagination.innerHTML += `
                        <button class="pagination-btn bg-yellow-500 text-white px-4 py-2 rounded ${i == data.currentPage ? 'font-bold' : ''}" data-page="${i}">
                            ${i}
                        </button>
                    `;
                }
            })
            .catch(error => console.error("Erreur lors du chargement des événements:", error));
    }

    document.getElementById("pagination").addEventListener("click", function (e) {
        if (e.target.classList.contains("pagination-btn")) {
            let page = e.target.getAttribute("data-page");
            loadEvents(page);
        }
    });
});


$(document).ready(function() {
    $(".category-btn").on("click", function(e) {
        e.preventDefault();
        let categoryId = $(this).data("category-id");
        loadEvents(1, categoryId);
    });

    $(".pagination").on("click", ".pagination-link", function(e) {
        e.preventDefault();
        let page = $(this).data("page");
        let categoryId = $(".category-btn.active").data("category-id");
        loadEvents(page, categoryId);
    });

    function loadEvents(page, categoryId = null) {
        $.ajax({
            url: "/?ajax=1&page=" + page + "&category=" + categoryId,
            method: "GET",
            success: function(response) {
                if (typeof response === "string") {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error("Failed to parse response:", e);
                        return;
                    }
                }

                if (response && Array.isArray(response.events)) {
                    $("#event-list").html("");
                    response.events.forEach(function(event) {
                        let eventHtml = `
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden group hover:scale-105 transition-transform duration-500">
                                <div class="relative">
                                    <img src="../../../images/${event.couverture}" alt="Event Image" 
                                        class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                                    <a href="/single-page?id=${event.id}" class="absolute top-3 left-3 bg-white text-yellow-500 px-3 py-1 rounded-full">View</a>
                                    <span class="absolute bottom-3 right-3 bg-yellow-500 text-white px-3 py-1 rounded-full">
                                        ${event.type === 'payant' ? '$' + event.prix : 'Gratuit'}
                                    </span>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold transition-all duration-500 group-hover:translate-y-2">${event.titre}</h3>
                                    <div class="flex items-center gap-2 text-gray-600 mt-2">
                                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">${event.event_type}</span>
                                        <span>📅 ${new Date(event.date_event).toLocaleDateString()}</span>
                                        <span>📍 ${event.adresse}</span>
                                    </div>
                                    <p class="text-gray-600 mt-3">${event.description.substring(0, 100)}...</p>
                                    <div class="flex justify-end items-center gap-4 mt-4">
                                        <button class="text-gray-600 hover:text-blue-500 text-xl">
                                            <i class="fas fa-thumbs-up"></i> ${event.likes}
                                        </button>
                                        <button class="text-gray-600 hover:text-red-500 text-xl">
                                            <i class="fas fa-thumbs-down"></i> ${event.dislikes}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $("#event-list").append(eventHtml);
                    });
                } else {
                    console.error("Invalid response format: 'events' is missing or malformed", response);
                }

                $(".pagination").html("");
                for (let i = 1; i <= response.totalPages; i++) {
                    let activeClass = i === response.currentPage ? "active" : "";
                    $(".pagination").append(`<a href="#" class="pagination-link ${activeClass}" data-page="${i}">${i}</a>`);
                }
            },
            error: function() {
                console.log("Error loading events");
            }
        });
    }
});










