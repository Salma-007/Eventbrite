    function openForm() {
        document.getElementById('formPopup').classList.remove('hidden');
        document.body.classList.add('no-scroll'); 
    }

    function closeForm() {
        document.getElementById('formPopup').classList.add('hidden');
        document.body.classList.remove('no-scroll'); 
    }

    document.addEventListener("DOMContentLoaded", function () {
        const typeDropdown = document.getElementById('type');
        const eventTypeDropdown = document.getElementById('event_type');
        const prixField = document.getElementById('prixField');
        const localisationField = document.getElementById('localisationField');
        const lienField = document.getElementById('lienField');
    
        if (typeDropdown && eventTypeDropdown) {
            typeDropdown.addEventListener('change', togglePrixField);
            eventTypeDropdown.addEventListener('change', toggleEventTypeFields);
        }
    
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
    });
    
   

    function openForms() {
        document.getElementById('formPopups').classList.remove('hidden');
        document.body.classList.add('no-scroll');
    }

    function closeForms() {
        document.getElementById('formPopups').classList.add('hidden');
        document.body.classList.remove('no-scroll');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const regionSelect = document.getElementById('region-select');
        const villeSelect = document.getElementById('ville-select');
    
        if (regionSelect && villeSelect) {
            regionSelect.addEventListener('change', function() {
                const regionId = this.value;
                villeSelect.innerHTML = '<option value="">Sélectionner une ville</option>';
    
                if (regionId) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', 'get_villes?id=' + regionId, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            const villes = JSON.parse(xhr.responseText);
                            villes.forEach(ville => {
                                const option = document.createElement('option');
                                option.value = ville.id;
                                option.textContent = ville.name;
                                villeSelect.appendChild(option);
                            });
                        }
                    };
                    xhr.send();
                }
            });
        } else {
            console.error("region-select or ville-select not found in the DOM.");
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('eventForm').addEventListener('submit', function (event) {
            event.preventDefault(); 
            
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/create-event', true);
            
            xhr.onload = function () {
                var errorMessages = document.getElementById('errorMessages');
                errorMessages.style.display = 'none'; 
                
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        
                        if (response.errors) {
                            errorMessages.style.display = 'block';
                            var errorContent = '';
                            for (var field in response.errors) {
                                errorContent += '<p>' + response.errors[field] + '</p>';
                            }
                            errorMessages.innerHTML = errorContent;
                        } else {
                            window.location.href = '/event';
                            Swal.fire({
                                title: "Good job!",
                                text: "Event created successfully!",
                                icon: "success"
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        alert('There was an error processing your request. Please try again.');
                    }
                } else {
                    console.error('An error occurred while processing the form.');
                    alert('An error occurred while submitting the form. Please try again.');
                }
            };
            
            xhr.send(formData);
        });
    
        document.getElementById('type').addEventListener('change', function () {
            var prixField = document.getElementById('prixField');
            if (this.value === 'payant') {
                prixField.classList.remove('hidden');
            } else {
                prixField.classList.add('hidden');
            }
        });
    
        document.getElementById('event_type').addEventListener('change', function () {
            var lienField = document.getElementById('lienField');
            var localisationField = document.getElementById('localisationField');
            if (this.value === 'live') {
                lienField.classList.remove('hidden');
                localisationField.classList.add('hidden');
            } else if (this.value === 'presentiel') {
                lienField.classList.add('hidden');
                localisationField.classList.remove('hidden');
            }
        });
    });
    
    

    