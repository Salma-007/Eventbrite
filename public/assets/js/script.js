function openForm() {
    document.getElementById('formPopup').classList.remove('hidden');
    document.body.classList.add('no-scroll'); 
}

function closeForm() {
    document.getElementById('formPopup').classList.add('hidden');
    document.body.classList.remove('no-scroll'); 
}

document.getElementById('eventForm').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Event created successfully!');
    closeForm();
});