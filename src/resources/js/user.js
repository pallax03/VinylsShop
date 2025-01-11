function deleteUser(id) {
    makeRequest(fetch(`/user?id_user=`+id, {
        method: 'DELETE'
    })).then((data) => {
        createNotification(data, true, '/dashboard/users', 'bi bi-person');
        setTimeout(() => { redirect('/dashboard/users'); }, 2000);
    })
    .catch((error) => {
        createNotification(error, false);
    });
}