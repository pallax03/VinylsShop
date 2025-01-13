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
    document.querySelectorAll("input").forEach(elem => {
        if (elem.id !==  "input-track_title_" + document.getElementById("ul-tracks").childElementCount ||
            elem.id !== "input-track_duration_" + document.getElementById("ul-tracks").childElementCount) {
            flag = flag && validateData(elem);
        }
    });
    if (!flag) {
        return;
    }
    let body = [];
    // getting info from fields
    body['cost'] = parseFloat(document.getElementById('input-add_cost').value);
    body['inch'] = document.querySelector('input[name="inch"]:checked').value;
    body['type'] = document.querySelector('input[name="type"]:checked').value;
    body['rpm'] = document.querySelector('input[name="rpm"]:checked').value;
    body['stock'] = document.getElementById('input-add_stock').value;
    body['album']['title'] = document.getElementById('input-album_title').value;
    body['album']['release_date'] = document.getElementById('input-album_releasedate').value;
    body['album']['genre'] = document.getElementById('input-album_genre').value;
    // artist check
    const artists = document.getElementById('datalist-album_artists').childNodes;
    artists.forEach(artist => {
        if (artist.value == document.getElementById('input-album_artist').value) {
            body['album']['artist']['id_artist'] = artist.id;
        }
    });
    body['album']['artist']['name'] = document.getElementById('input-album_artist').value;
    body['album']['tracks'] = [];
    document.getElementById("ul-tracks").childNodes.forEach(node => {
        if (node !== document.getElementById("ul-tracks").lastChild) { 
            body['album']['tracks'].push(node.childNodes)
        }
    });
    for (let index = 1; index < document.getElementById("ul-tracks").childElementCount-1; index++) {
        let track = [];
        track['title'] = document.getElementById("input-track_title_" + index);
        track['duration'] = document.getElementById("input-track_duration_" + index); 
        body['album']['tracks'].push(track);
    }
    console.log(body);
    makeRequest(fetch('/vinyl', {
        method: 'POST',
        body: body
    })).then(data => { createNotification(data, true); }).catch(error => { createNotification(error, false); });
});