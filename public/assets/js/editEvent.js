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

        document.getElementById('region-select').addEventListener('change', function () {
            const regionId = this.value;
            const villeSelect = document.getElementById('ville-select');
            const selectedVilleId = villeSelect.getAttribute('data-selected'); // Récupère la ville actuelle
        
            villeSelect.innerHTML = '<option value="">Sélectionner une ville</option>';
        
            if (regionId) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_villes?id=' + regionId, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        console.log("Réponse brute du serveur:", xhr.responseText); // Vérifie la réponse AJAX
                        
                        if (xhr.status === 200) {
                            try {
                                const villes = JSON.parse(xhr.responseText);
                                console.log("Villes reçues :", villes); // Debugging
        
                                villes.forEach(ville => {
                                    const option = document.createElement('option');
                                    option.value = ville.id;
                                    option.textContent = ville.name;
                                    
                                    if (ville.id == selectedVilleId) { 
                                        option.selected = true;
                                    }
        
                                    villeSelect.appendChild(option);
                                });
                            } catch (error) {
                                console.error("Erreur de parsing JSON :", error);
                            }
                        } else {
                            console.error("Erreur AJAX :", xhr.status);
                        }
                    }
                };
                xhr.send();
            }
        });
        
        


        document.getElementById('eventForm').addEventListener('submit', function (e) {
            e.preventDefault();
        
            let formData = new FormData(this);
            let errorDiv = document.getElementById('error-messages');
            let errorList = document.getElementById('error-list');
        
            errorDiv.classList.add('hidden');
            errorList.innerHTML = '';
        
            fetch('/update-event', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.success) {
                        Swal.fire({
                            title: "Votre Event a été modifié!",
                            text: "Redirection en cours...",
                            icon: "success",
                            timer: 2000, 
                            showConfirmButton: false 
                        }).then(() => {
                            window.location.href = '/event';  
                        });
                    } 
                } else {
                    if (Array.isArray(data.errors)) {
                        data.errors.forEach(error => {
                            let li = document.createElement('li');
                            li.textContent = error;
                            errorList.appendChild(li);
                        });
                        errorDiv.classList.remove('hidden');
                    } 
                    else if (typeof data.errors === 'object') {
                        Object.keys(data.errors).forEach(key => {
                            let value = data.errors[key];
                            if (Array.isArray(value)) {
                                value.forEach(error => {
                                    let li = document.createElement('li');
                                    li.textContent = error;
                                    errorList.appendChild(li);
                                });
                            } else {
                                let li = document.createElement('li');
                                li.textContent = value;
                                errorList.appendChild(li);
                            }
                        });
                        errorDiv.classList.remove('hidden');
                    } 
                    else {
                        let li = document.createElement('li');
                        li.textContent = data.errors || "Une erreur inconnue s'est produite.";
                        errorList.appendChild(li);
                        errorDiv.classList.remove('hidden');
                    }
                }
            })
            .catch(error => console.error("Erreur AJAX :", error));
        });
        
        
        
        
        