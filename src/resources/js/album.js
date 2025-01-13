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
    
    makeRequest(fetch('/vinyl', {
        method: 'POST',
        body: formData
    })).then(data => { createNotification(data, true); setTimeout(() => {}, 2000); }).catch(error => { createNotification(error, false); });
});