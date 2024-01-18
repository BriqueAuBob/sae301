let notificationElements = document.querySelectorAll('.notification');
const notificationCount = document.getElementById('readNotificationsCount');
console.log(notificationCount);
notificationElements.forEach(function (notificationElement) {
    notificationElement.addEventListener('click', function () {

        if(notificationElement.classList.contains('opacity-50')){
            return;
        }
        let notificationId = notificationElement.dataset.notificationId;

        notificationCount.innerHTML = parseInt(notificationCount.innerHTML) - 1;

        fetch('/notification/' + notificationId, {
            method: 'PATCH',
        });
        notificationElement.classList.add('opacity-50') ;


    });
});
