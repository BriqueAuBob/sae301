let notificationElements = document.querySelectorAll('.notification');

notificationElements.forEach(function (notificationElement) {
    notificationElement.addEventListener('click', function () {
        let notificationId = notificationElement.dataset.notificationId;

        console.log('test:', notificationId);

        fetch('/notification/' + notificationId, {
            method: 'PATCH',
        });
        document.getElementById('card-notification-' + notificationId).style.opacity = "0.5";

    });
});
