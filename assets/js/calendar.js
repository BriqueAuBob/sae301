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

// Changement de l'état de la modale'
function toggleModaleCalendar(selector, state){
    if(state === true){
        setTimeout(function(){
            // Opacity
            selector.addClass('opacity-1');
            selector.removeClass('opacity-0');

            // Pointer events
            selector.addClass('pointer-events-auto');
            selector.removeClass('pointer-events-none');

            // Translate
            selector.find('.modal-content').addClass('-translate-y-1/2');
            selector.find('.modal-content').removeClass('translate-y-8');
            console.log(selector.find('.modal-content'));

            // Scale
            selector.find('.modal-content').addClass('scale-100');
            selector.find('.modal-content').removeClass('scale-75');
        }, 100)
        console.log('true');
    }else if(state === false){
        // Opacity
        selector.addClass('opacity-0');
        selector.removeClass('opacity-1');

        // Pointer events
        selector.addClass('pointer-events-none');
        selector.removeClass('pointer-events-auto');

        // Translate
        selector.find('.modal-content').addClass('translate-y-8');
        selector.find('.modal-content').removeClass('translate-y-0');

        // Scale
        selector.find('.modal-content').addClass('scale-75');
        selector.find('.modal-content').removeClass('scale-100');

        console.log('false');
    }

}
// Ouverture de la modale
function modalCalendar(divCalendar) {
    let target = $(divCalendar).attr('id');
    let selector = $('#'+target);
    console.log(target);
    if (target === 'modal-homework-calendar') {
        toggleModaleCalendar(selector, true);
    }
}

// Fermeture de la modale
$("#CalendarModale").click(function(event){
    if(event.target.classList.contains('closeModalButton')){
        let selector = $("#modal-homework-calendar");
        toggleModaleCalendar(selector, false);
    }
    if($(event.target).hasClass('bgCloseModal') ){
        let selector = $("#modal-homework-calendar");
        toggleModaleCalendar(selector, false);
        // console.log('test');
    }
    console.log(event.target);
})
