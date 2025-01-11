let number = 1;

function duplicateTrack() {
    const track = `
        <li class="split">
            <label for="input-track_title_${number}">Track #${number}</label>
            <input type="text" id="input-track_title" name="track_title" required />
        </li>
        <li class="split">
            <label for="input-track_duration_${number}">Duration</label>
            <input type="text" id="input-track_duration" name="track_duration" required />
        </li>`;

    return track;
}


function refreshSelector() {
    document.getElementById('input-track_duration_'+number).addEventListener('blur', function (e) {
        number++;
        const track = duplicateTrack();
        document.getElementById('ul-tracks').insertAdjacentHTML('beforeend', track);
        refreshSelector();
    });
}

refreshSelector();