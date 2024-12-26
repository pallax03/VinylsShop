
function setDefaultCard(id= '') {
    fetch('/user/defaults', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_card: id
        })
    }).then((response) => {
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
    });
}

function deleteCard(id) {
    fetch('/user/card?id_card=' + id, {
        method: 'DELETE',
        headers: {}
    }).then((response) => {
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
    });
}


// Automatically add slash after entering the month
document.getElementById('input-card_exp').addEventListener('input', function (e) {
    let value = e.target.value; 
    if (value.length === 2 && !value.includes('/')) {
        e.target.value = value + '/';
    }
});

document.getElementById('btn-card_submit').addEventListener('click', function() {
    card_number = document.getElementById('input-card_number');
    card_number.parse = /^(?:\d[ -]*?){13,19}$/;
    card_expiry = document.getElementById('input-card_exp');
    card_expiry.parse = /^(0[1-9]|1[0-2])\/[0-9]{2}$/;
    card_cvc = document.getElementById('input-card_cvc');
    card_cvc.parse = /^\d{3}$/;
    if(validateData(card_number, card_expiry, card_cvc)) {
        const expiryParts = card_expiry.value.split('/');
        const mysqlDate = `20${expiryParts[1]}-${expiryParts[0]}-01`;
        if (new Date(mysqlDate) < new Date()) {
            card_expiry.classList.add('error');
        } else {
            document.getElementById('form-card').submit();
        }
    }
});