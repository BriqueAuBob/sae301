document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const eventData = JSON.parse(calendarEl.dataset.events || '[]');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        timeZone: 'local',
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour',
            list: 'Liste'
        },
        headerToolbar:{
            start: 'prev,next today',
            center: 'title',
            end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        events: eventData,
        dateClick: function(arg) {
            console.log(arg.date.toString());
        },
        eventClick: function(info) {
            //Appel en ajax pour la modale
            console.log(info.event.id);

            info.el.style.borderColor = 'red';
        }
    });

    calendar.setOption('locale', 'fr');
    calendar.render();
});