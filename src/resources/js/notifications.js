function deleteNotification(notification_id) {
    makeRequest(fetch('/notification?id='+notification_id, {
        method: 'DELETE'
    })).then((data) => {
        window.location.reload();
    }).catch((error) => {
    });
}

function readNotification(notification_id) {
    makeRequest(fetch('/notification', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: notification_id })
    })).then((data) => {
        document.getElementById('card-notification_' + notification_id).classList.remove('unread');
    }).catch((error) => {
    });
}