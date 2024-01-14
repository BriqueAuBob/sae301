
const deleteButton = document.querySelectorAll('.delete');

deleteButton.forEach(button => {
    button.addEventListener('click', () => {
        fetch('/homework/' + button.dataset.homeworkId, {
            method: 'DELETE',
        });
        document.getElementById('card-homework-' + button.dataset.homeworkId).remove();
        button.remove();
    });
});
