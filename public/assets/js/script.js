function openForm() {
    document.getElementById('formPopup').classList.remove('hidden');
}

function closeForm() {
    document.getElementById('formPopup').classList.add('hidden');
}

document.getElementById('eventForm').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Event created successfully!');
    closeForm();
});