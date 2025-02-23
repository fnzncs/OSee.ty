$(function() {
    // Fetch and display booking notifications
    fetchBookingNotification();

    function fetchBookingNotification() {
        $.ajax({
            url: 'booking_notification.php',
            success: function(response) {
                if (response) {
                    try {
                        const notification = JSON.parse(response);
                        if (notification.message) {
                            showPopup(notification.message, notification.isSuccess);
                        }
                    } catch (e) {
                        console.log('Error parsing notification response:', e);
                    }
                }
            },
            error: function() {
                console.log('Error fetching booking notification');
            }
        });
    }

    // Function to display pop-up message
    function showPopup(message, isSuccess) {
        const popupModal = document.getElementById('popupModal');
        const popupMessage = document.getElementById('popupMessage');

        popupMessage.textContent = message;
        popupModal.style.display = 'flex'; // Display the modal

        // Adjust styling based on success or error (optional)
        if (isSuccess) {
            popupModal.style.backgroundColor = 'rgba(0, 128, 0, 0.5)'; // Greenish background for success
        } else {
            popupModal.style.backgroundColor = 'rgba(255, 0, 0, 0.5)'; // Reddish background for error
        }

        // Automatically hide the pop-up after a few seconds (optional)
        setTimeout(function() {
            popupModal.style.display = 'none';
        }, 5000); // Adjust the time as per your requirement
    }
});
