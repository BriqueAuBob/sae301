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
        businessHours: {
            daysOfWeek: [ 1, 2, 3, 4, 5],

            startTime: '08:00',
            endTime: '20:00',
        },
        slotMinTime: '08:00',
        slotMaxTime: '20:00',
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
            $.ajax({
                url: '/homework/'+ info.event._def.extendedProps.HomeworkID+'/view/',
                type: 'GET',
                success: function(data){
                    $('#CalendarModale').html(data);
                    // console.log(data);
                    modalCalendar(data);
                }
            })

            info.el.style.borderColor = 'red';
        }
    });

    calendar.setOption('locale', 'fr');
    calendar.render();
});

function modalCalendar(div) {
    if ($(div).attr('id') === 'modal-homework-calendar') {
        $('#modal-homework-calendar').addClass('opacity-1');
        $('#modal-homework-calendar').removeClass('opacity-0');
        $('#modal-homework-calendar').removeClass('pointer-events-none');
        $('#modal-homework-calendar').addClass('pointer-events-auto');

        console.log('non');
    }
    console.log('non');
}
