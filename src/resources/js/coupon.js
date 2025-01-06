function loadCoupon(id) {
    coupon = document.getElementById('card-coupon_' + id);
    document.getElementById('input-discount_code').value = coupon.getAttribute('data-discount_code');
    document.getElementById('input-percentage').value = coupon.getAttribute('data-percentage');
    document.getElementById('input-valid_from').value = coupon.getAttribute('data-valid_from');
    document.getElementById('input-valid_until').value = coupon.getAttribute('data-valid_until');
    document.getElementById('form-coupon').setAttribute('data-id_coupon', id);
    document.getElementById('form-coupon').scrollIntoView({ behavior: 'smooth' });

}

function deleteCoupon(id) {
    fetch('/coupon?id_coupon=' + id, {
        method: 'DELETE',
        headers: {}
    }).then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
    }).catch((error) => {
        // TODO NOTIFICATIONS
        console.error('Error fetching address details:', error);
        alert('Error fetching address details.');
    });
}

document.getElementById('btn-coupon_submit').addEventListener('click', function() {
    let form = document.getElementById('form-coupon');
    let formData = new FormData(form);
    let id_coupon = form.getAttribute('data-id_coupon');
    if (id_coupon) {
        formData.append('id_coupon', id_coupon);
    }
    let method = 'POST';
    fetch('/coupon', {
        method: method,
        body: formData
    }).then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
    }).catch((error) => {
        // TODO NOTIFICATIONS
        console.error('Error fetching address details:', error);
        alert('Error fetching address details.');
    });
});



