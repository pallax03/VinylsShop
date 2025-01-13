let number = 1;

function duplicateTrack() {
    const track = `
        <li class="split">
            <label for="input-track_title_${number}">Track #${number}</label>
            <input type="text" id="input-track_title_${number}" name="track_title" />
        </li>
        <li class="split">
            <label for="input-track_duration_${number}">Duration</label>
            <input type="text" id="input-track_duration_${number}" name="track_duration" />
        </li>`;

    return track;
}

function nextSelector() {
    const oldTrack = document.getElementById('input-track_duration_'+number).parentElement;
    number++;
    const track = duplicateTrack();
    oldTrack.insertAdjacentHTML('afterend', track);
    oldTrack.querySelector('#input-track_duration_'+(number-1)).removeEventListener('blur', nextSelector);
    refreshSelector();
}


function refreshSelector() {
    document.getElementById('input-track_duration_'+number).addEventListener('blur', nextSelector);
}

refreshSelector();

document.getElementById("input-add_cost").addEventListener("blur", function () {
    const input = document.getElementById("input-add_cost");
    let value = input.value;
    if (value === "") {
        return;
    }
    value = parseFloat(value).toFixed(2);
    input.value = value;
});

document.getElementById("btn-album_submit").addEventListener("click", function (event) {
    let flag = true;
    let last_track = (document.getElementById("ul-tracks").childElementCount-1)/2;
    document.querySelectorAll("input").forEach(elem => {
        if (elem.id !=  "input-track_title_" + last_track &&
            elem.id != "input-track_duration_" + last_track) {
                flag = flag && validateData(elem);
        }
    });
    if (!flag) {
        return;
    }

    const formData = new FormData();

    // Add vinyl details
    formData.append('cost', parseFloat(document.getElementById('input-add_cost').value));
    formData.append('inch', document.querySelector('input[name="inch"]:checked').value);
    formData.append('type', document.querySelector('input[name="type"]:checked').value);
    formData.append('rpm', document.querySelector('input[name="rpm"]:checked').value);
    formData.append('stock', document.getElementById('input-add_stock').value);


    // already present artist check
    let artist_id = false;
    document.getElementById('datalist-album_artists').childNodes.forEach(artist => {
        if (artist.value == document.getElementById('input-album_artist').value) {
            artist_id = artist.id;
        }
    });
    
    // Add tracks
    let tracks = [];
    for (let index = 0; index < last_track - 1; index++) {
        tracks.push({
            title: document.getElementById('input-track_title_' + (index+1)).value,
            duration: document.getElementById('input-track_duration_' + (index+1)).value
        });
    }
    // Example JSON data (album details)
    const albumData = {
        title: document.getElementById('input-album_title').value,
        release_date: document.getElementById('input-album_releasedate').value,
        genre: document.getElementById('input-album_genre').value,
        artist: {
            id_artist: artist_id ? artist_id : '',
            name: document.getElementById('input-album_artist').value,
        },
        tracks: tracks,
    };

    formData.append('album', JSON.stringify(albumData));

    // Add image file
    const imageInput = document.getElementById('input-album_cover');
    if (imageInput.files.length > 0) {
        formData.append('cover', imageInput.files[0]);
    }

    makeRequest(fetch('/vinyl', {
        method: 'POST',
        body: formData,
    }))
    .then(data => { createNotification(data, true); })
    .catch(error => { createNotification(error, false); });
});