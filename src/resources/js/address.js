
function setDefaultAddress(id = '') {
    fetch('/user/defaults', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_address: id
        })
    }).then((response) => {
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
    });
}

function deleteAddress(id) {
    fetch('/user/address?id_address=' + id, {
        method: 'DELETE',
        headers: {}
    }).then((response) => {
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
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

document.getElementById('btn-address_submit').addEventListener('click', function() {
    street_and_number = document.getElementById('input-address_street');
    city = document.getElementById('input-address_city');
    cap = document.getElementById('input-address_cap');
    cap.parse = /^\d{5}$/;
    if(validateData(street_and_number, city, cap)) {
        document.getElementById('form-address').submit();
    }
});



