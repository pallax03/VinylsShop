document.addEventListener("DOMContentLoaded", function() {
    setInterval(function() {
        makeRequest(fetch('/notifications')).then((data) => {
            createNotification(data.message, true, data.link);
        }).catch((error) => {});
    }
    , 30000);
});