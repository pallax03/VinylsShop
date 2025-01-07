
function setDefaultCard(id= '') {
    makeRequest(fetch('/user/defaults', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_card: id
        })
    })).then((data) => {
        window.location.reload();
    }).catch((error) => {
        createNotification(error, false);
    });
}

function deleteCard(id) {
    makeRequest(fetch('/user/card?id_card=' + id, {
        method: 'DELETE',
        headers: {}
    })).then((data) => {
        window.location.reload();
    }).catch((error) => {
        createNotification(error, false);
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
        makeRequest(fetch('/user/card', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                card_number: card_number.value,
                card_exp: card_expiry.value,
                card_cvc: card_cvc.value
            })
        })).then((data) => {
            window.location.reload();
        }).catch((error) => {
            createNotification(error, false);
        });
    }
});