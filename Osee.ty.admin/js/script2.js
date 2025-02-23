document.getElementById("exportBtn").addEventListener("click", function() {
    var calendarData = document.getElementById("calendarContainer").innerHTML;
    // Send calendar data to PHP script
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "export.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Response handling (if needed)
            console.log(xhr.responseText);
        }
    };
    xhr.send("calendarData=" + encodeURIComponent(calendarData));
});
