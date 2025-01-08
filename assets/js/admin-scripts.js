document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-partner');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            if (!confirm('Are you sure you want to delete this partner?')) {
                event.preventDefault();
            }
        });
    });
});
