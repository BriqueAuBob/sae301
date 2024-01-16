document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar')
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
        events: [
            { start: '2018-09-01T12:30:00Z' },
            { start: '2018-09-01T12:30:00+XX:XX' },
            { start: '2018-09-01T12:30:00' }
        ],
        dateClick: function(arg) {
            console.log(arg.date.toString());
        }
    })
    calendar.setOption('locale', 'fr');
    calendar.render()
})