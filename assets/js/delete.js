const deleteAction = (elements, callback) => {
    elements.forEach(button => {
        button.addEventListener('click', () => {
            callback(button)
        });
    });
}

deleteAction(document.querySelectorAll('.delete'), (button) => {
    fetch('/homework/' + button.dataset.homeworkId, {
        method: 'DELETE',
    });
    document.getElementById('card-homework-' + button.dataset.homeworkId).remove();
    button.remove();
})

deleteAction(document.querySelectorAll('.delete-notification'), (button) => {
    fetch('/notification/' + button.dataset.notificationId, {
        method: 'DELETE',
    });
    document.getElementById('card-notification-' + button.dataset.notificationId).remove();
    button.remove();
});

export { deleteAction };