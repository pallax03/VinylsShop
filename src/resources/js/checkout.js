function updateTotal(total, difference, percentage) {
    document.getElementById('p-checkout_total').innerHTML = total +  ' €';
    document.getElementById('p-discount_difference').innerHTML = '- ' +difference.toFixed(2) + ' €';
    document.getElementById('p-discount_percentage').innerHTML = percentage + '%';
    document.getElementById('p-checkout_submit').innerHTML = total + ' €';
}

function getTotal() {
    discount_code = document.getElementById('input-discount_code').value;
    makeRequest(fetch('/checkout/total?discount_code=' + discount_code, {
      method: 'GET',
    })).then(data => {
        updateTotal(data.total, data.difference, data.percentage);
    }).catch((error) => {
        autoRefresh();
    });
}

// when the discount code is entered, fetch the new total
document.getElementById('input-discount_code').addEventListener('blur', getTotal);
window.addEventListener('pageshow', function (event) {
    getTotal(); // Always call it on pageshow, regardless of whether it's cached or not
});

document.getElementById('btn-checkout_submit').addEventListener('click', function() {
    discount_code = document.getElementById('input-discount_code').value
    makeRequest(fetch('/checkout', {
      method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({discount_code: discount_code})
    })).then(data => {
        redirect('/user');
    }).catch((error) => {
        createNotification(error, false);
    });
});