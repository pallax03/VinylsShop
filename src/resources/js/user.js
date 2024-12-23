// document.getElementById('delete-account').addEventListener('click', function() {
//     fetch('/user', {
//         method: 'DELETE',
//         headers: {}
//     }).then((response) => {
//         if (!response.ok) {
//             throw new Error("Server response was not ok");
//         }
//         return response.json();
//     }).then((data) => {
//         console.log(data);
//         window.location.href = '/logout';
//     });
// });

// contact nominatim for address help
document.getElementById('input-address_street').addEventListener('click', function() {
    fetch('https://nominatim.openstreetmap.org/search?q=' + document.getElementById('input-address_street').value + '&format=json&addressdetails=1&limit=5', {
        method: 'GET',
        headers: {}
    }).then((response) => {
        return response.json();
    }).then((data) => {
        console.log(data);
        document.getElementById('address-suggestions').innerHTML = '';
        data.forEach(function (address) {
            document.getElementById('address-suggestions').innerHTML += '<div class="address-suggestion" data-lat="' + address.lat + '" data-lon="' + address.lon + '">' + address.display_name + '</div>';
        });
    });
});

document.getElementById('btn-address_submit').addEventListener('click', function() {
    street_and_number = document.getElementById('input-address_street');
    city = document.getElementById('input-address_city');
    cap = document.getElementById('input-address_cap');
    cap.parse = /^\d{5}$/;
    if(validateData(street_and_number, city, cap)) {
        // document.getElementById('address-form').submit();
    } else {
        alert('Please fill in all fields correctly');
    }
});