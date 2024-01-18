$(document).ready(function(){
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
                    modalCalendar(data);
                }
            })

            info.el.style.borderColor = 'red';
        }
    });

    calendar.setOption('locale', 'fr');
    calendar.render();
})
function toggleModaleCalendar(selector){
    selector.toggleClass('opacity-0', 'opacity-1');
    selector.toggleClass('pointer-events-none', 'pointer-events-auto');
    selector.find('.modal-content').toggleClass('translate-y-8', 'translate-y-0');
    selector.find('.modal-content').toggleClass('-translate-y-1/2', 'translate-y-0');
    selector.find('.modal-content').toggleClass('scale-75', 'scale-100');
}
function modalCalendar(divCalendar) {
    let dc = divCalendar;
    let dcId = $(dc).attr('id');
    let selector = $('#'+dcId);
    console.log(dcId);
    if (dcId === 'modal-homework-calendar') {
        toggleModaleCalendar(selector);
        console.log('oui');
    }else {
        console.log('non');
    }
}