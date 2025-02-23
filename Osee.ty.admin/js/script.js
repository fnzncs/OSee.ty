var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];
$(function() {
    events = [];
    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k];
            events.push({
                id: row.id,
                fullname: row.fullname,
                title: row.title,
                start: row.start_datetime,
                end: row.end_datetime,
                description: row.description,
                company_name: row.company_name,
                venue: row.venue,
                status: row.status
            });
        });
    }

    // Initialize FullCalendar
    calendar = new Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
        selectable: true,
        themeSystem: 'bootstrap',
        events: events,
        eventClick: function(info) {
            var _details = $('#event-details-modal');
            var id = info.event.id;
            if (!!scheds[id]) {
                _details.find('#title').text(scheds[id].title);
                _details.find('#description').text(scheds[id].description);
                _details.find('#reason').text(scheds[id].reason);
                _details.find('#fullname').text(scheds[id].fullname);
                _details.find('#start').text(scheds[id].start_datetime);
                _details.find('#end').text(scheds[id].end_datetime);
                _details.find('#company_name').text(scheds[id].company_name);
                _details.find('#venue').text(scheds[id].venue);
                _details.find('#cancel-event').attr('data-id', id);

                // Display and style status
                var statusElement = _details.find('#status');
                var status = scheds[id].status;
                statusElement.text(status);

                if (status.toLowerCase() === 'accepted') {
                    statusElement.addClass('status-accepted').removeClass('status-denied status-canceled');
                } else if (status.toLowerCase() === 'denied') {
                    statusElement.addClass('status-denied').removeClass('status-accepted status-canceled');
                } else if (status.toLowerCase() === 'canceled') {
                    statusElement.addClass('status-canceled').removeClass('status-accepted status-denied');
                } else {
                    statusElement.removeClass('status-accepted status-denied status-canceled');
                }

                _details.modal('show');
            } else {
                alert("Event is undefined");
            }
        },
        eventDidMount: function(info) {
            // Do Something after events mounted
        },
        editable: true
    });

    calendar.render();
// Form reset listener
$('#schedule-form').on('reset', function() {
    $(this).find('input:hidden').val('');
    $(this).find('input:visible').first().focus();
});

    // Add form validation for time slots
    document.getElementById('schedule-form').addEventListener('submit', function(event) {
        var start = new Date(document.getElementById('start_datetime').value);
        var end = new Date(document.getElementById('end_datetime').value);
        var startHour = start.getHours();
        var endHour = end.getHours();
        var startDate = start.toDateString();
        var endDate = end.toDateString();

        // Check for conflicts
        var hasConflict = events.some(function(e) {
            var eventStart = new Date(e.start);
            var eventEnd = new Date(e.end);
            var eventStartDate = eventStart.toDateString();
            var eventEndDate = eventEnd.toDateString();

            // Check if events are on the same day and venue
            if (e.venue === document.getElementById('venue').value &&
                (startDate === eventStartDate || endDate === eventEndDate)) {
                return true;
            }

            return false;
        });

        if (hasConflict) {
            alert("The selected venue is already booked for the chosen date.");
            event.preventDefault();
            return;
        }
    });

// Edit Button
$('#edit').click(function() {
    var id = $(this).attr('data-id');
    if (!!scheds[id]) {
        var _form = $('#schedule-form');
        _form.find('[name="id"]').val(id);
        console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "T"));
        _form.find('[name="title"]').val(scheds[id].title);
        _form.find('[name="description"]').val(scheds[id].description);
        _form.find('[name="reason"]').val(scheds[id].reason);
        _form.find('[name="fullname"]').val(scheds[id].fullname);
        _form.find('[name="company_name"]').val(scheds[id].company_name);
        _form.find('[name="venue"]').val(scheds[id].venue);
        _form.find('[name="email"]').val(scheds[id].email);
        _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"));
        _form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"));
        _form.find('[name="status"]').val(scheds[id].status);
        $('#event-details-modal').modal('hide');
        _form.find('[name="title"]').focus();
    } else {
        alert("Event is undefined");
    }
});

// Delete Button / Deleting an Event
$('#delete').click(function() {
    var id = $(this).attr('data-id');
    if (!!scheds[id]) {
        var _conf = confirm("Are you sure to delete this scheduled event?");
        if (_conf === true) {
            location.href = "./delete_schedule.php?id=" + id;
        }
    } else {
        alert("Event is undefined");
    }
});
});

