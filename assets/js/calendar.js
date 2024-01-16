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
        events: eventData,
        dateClick: function(arg) {
            console.log(arg.date.toString());
        }
    });

    calendar.setOption('locale', 'fr');
    calendar.render();
});
