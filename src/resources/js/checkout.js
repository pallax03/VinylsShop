function updateTotal(total, difference, percentage) {
    document.getElementById('p-checkout_total').innerHTML = total +  ' €';
    document.getElementById('p-discount_difference').innerHTML = '- ' +difference.toFixed(2) + ' €';
    document.getElementById('p-discount_percentage').innerHTML = percentage + '%';
    document.getElementById('p-checkout_submit').innerHTML = total + ' €';
}

function getTotal() {
    discount_code = document.getElementById('input-discount_code').value;
    fetch('/checkout/total?discount_code=' + discount_code, {
      method: 'GET',
    }).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }).then(data => {
        data = data.message;
        updateTotal(data.total, data.difference, data.percentage);
    }).catch((error) => {
        console.error('Error:', error);
    });
}

// when the discount code is entered, fetch the new total
document.getElementById('input-discount_code').addEventListener('blur', getTotal);
window.addEventListener('pageshow', function (event) {
    getTotal(); // Always call it on pageshow, regardless of whether it's cached or not
});