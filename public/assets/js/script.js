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

    