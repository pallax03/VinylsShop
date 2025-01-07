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
    makeRequest(fetch('/coupon?id_coupon=' + id, {
        method: 'DELETE',
        headers: {}
    })).then((data) => {
        window.location.reload();
    }
    ).catch((error) => {
        createNotification(error, false);
    });
}

document.getElementById('btn-coupon_reset').addEventListener('click', function() {
    document.getElementById('form-coupon').reset();
    document.getElementById('form-coupon').removeAttribute('data-id_coupon');
});

document.getElementById('btn-coupon_submit').addEventListener('click', function() {
    let form = document.getElementById('form-coupon');
    let formData = new FormData(form);
    let id_coupon = form.getAttribute('data-id_coupon');
    if (id_coupon !== '' || id_coupon !== null) {
        formData.append('id_coupon', id_coupon);
    }
    makeRequest(fetch('/coupon', {
        method: 'POST',
        body: formData
    })).then((data) => {
        window.location.reload();
    }
    ).catch((error) => {
        createNotification(error, false);
    });
});