function setDefaultAddress(id = '') {
    makeRequest(fetch('/user/defaults', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_address: id
        })
    })).then((data) => {
        autoRefresh();
    }).catch((error) => {
        createNotification(error, false);
    });
}

function deleteAddress(id) {
    makeRequest(fetch('/user/address?id_address=' + id, {
        method: 'DELETE',
        headers: {}
    })).then((data) => {
        autoRefresh();
    }).catch((error) => {
        createNotification(error, false);
    });
}

// WORK IN PROGRESS
// document.getElementById('input-address_street').addEventListener('blur', function() {
//     const streetInput = document.getElementById('input-address_street').value;
//     if (streetInput.length > 5) {
//         fetchAddressDetails(streetInput);
//     }
// });

// function fetchAddressDetails(street) {
//     const nominatimApiUrl = `https://nominatim.openstreetmap.org/search?street=${encodeURIComponent(street)}&country=Italy&format=json&addressdetails=1&limit=1`;

//     fetch(nominatimApiUrl)
//         .then(response => response.json())
//         .then(data => {
//             if (data.length > 0) {
//                 const address = data[0].address;

//                 // Popola i campi CAP, Città e Provincia
//                 if (address.postcode) {
//                     document.getElementById('input-address_cap').value = address.postcode;
//                 }
//                 if (address.city || address.town || address.village) {
//                     document.getElementById('input-address_city').value = address.city || address.town || address.village;
//                 }
//             } else {
//                 alert('No results found for the provided address.');
//             }
//         })
//         .catch(error => {
//             console.error('Error fetching address details:', error);
//             alert('Error fetching address details.');
//         });
// }

document.getElementById('btn-address_submit').addEventListener('click', function () {
    address_name = document.getElementById('input-address_name');
    street_and_number = document.getElementById('input-address_street');
    city = document.getElementById('input-address_city');
    cap = document.getElementById('input-address_cap');
    cap.parse = /^\d{5}$/;
    if (validateData(address_name, street_and_number, city, cap)) {
        makeRequest(fetch('/user/address', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                address_name: address_name.value,
                address_street: street_and_number.value,
                address_city: city.value,
                address_cap: cap.value
            })
        })).then((data) => {
            autoRefresh();
        }).catch((error) => {
            createNotification(error, false);
        });
    }
});



