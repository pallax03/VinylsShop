document.addEventListener("DOMContentLoaded", function() {
    setInterval(function() {
        makeRequest(fetch('/notifications')).then((data) => {
            createNotification(data.message, true, data.link, data.created_at);
        }).catch((error) => {});
    }
    , 30000);
});