var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {
    // Populate events array with data from PHP
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
                reason: row.reason,
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
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,list'
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
            // Do something after events are mounted
        },
        editable: true
    });

    // Render calendar
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
        var selectedVenue = document.getElementById('venue').value; // Get selected venue

        // Check for conflicts
        var hasConflict = events.some(function(e) {
            var eventStart = new Date(e.start);
            var eventEnd = new Date(e.end);
            var eventStartDate = eventStart.toDateString();
            var eventEndDate = eventEnd.toDateString();

            // Check if events are on the same day and at the same venue
        if (e.venue === selectedVenue &&
            ((start >= eventStart && start < eventEnd) ||
            (end > eventStart && end <= eventEnd) ||
            (start <= eventStart && end >= eventEnd))) {
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

    $(document).ready(function() {
        // Event delegation for close button and other dismissals
        $(document).on('click', '[data-dismiss="modal"]', function() {
            var targetModal = $(this).closest('.modal');
            $(targetModal).modal('hide');
        });
    
        // Event delegation for cancel event button
        $(document).on('click', '#cancel-event', function() {
            var venue = $(this).data('id');
            console.log("Cancel event clicked with ID: ", venue); // Log the event ID to verify it's correct
            if (venue) {
                $('#cancel-event-id').val(venue);
                $('#cancel-request-modal').modal('show');
            } else {
                alert('Invalid event ID.');
            }
        });
    
        // Form submission for cancellation request
        $('#cancel-request-form').on('submit', function(e) {
            e.preventDefault();
            var venue = $('#cancel-event-id').val();
            var reason = $('#reason').val();
    
            // Validate event ID and reason
            if (!venue || !reason) {
                alert("Both Event ID and Reason are required.");
                return;
            }
    
            console.log("Submitting cancellation request for event ID:", venue, "with reason:", reason);
    
            if (confirm('Are you sure you want to request cancellation for this event?')) {
                $.ajax({
                    url: 'cancel_event.php',
                    method: 'POST',
                    data: { id: venue, reason: reason },
                    success: function(response) {
                        console.log("Server response: ", response); // Log the server response
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert('Cancellation request sent. Waiting for admin approval.');
                            location.reload();
                        } else {
                            alert('Error: ' + res.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while sending the cancellation request.');
                    }
                });
            }
        });
    });                 
});