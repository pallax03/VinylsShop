function deleteUser(id) {
    makeRequest(fetch(`/user?id_user=`+id, {
        method: 'DELETE'
    })).then((data) => {
        createNotification(data, true, '/dashboard/users', 'bi bi-person');
        setTimeout(() => { window.location.href = '/dashboard/users'; }, 2000);
    })
    .catch((error) => {
        createNotification(error, false);
    });
}