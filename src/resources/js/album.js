let number = 1;

function duplicateTrack() {
    const track = `
        <li class="split">
            <label for="input-track_title_${number}">Track #${number}</label>
            <input type="text" id="input-track_title_${number}" name="track_title" required />
        </li>
        <li class="split">
            <label for="input-track_duration_${number}">Duration</label>
            <input type="text" id="input-track_duration_${number}" name="track_duration" required />
        </li>`;

    return track;
}

function nextSelector() {
    const oldTrack = document.getElementById('input-track_duration_'+number).parentElement;
    oldTrack.removeEventListener('blur', nextSelector);
    number++;
    const track = duplicateTrack();
    oldTrack.insertAdjacentHTML('afterend', track);
    refreshSelector();
}


function refreshSelector() {
    document.getElementById('input-track_duration_'+number).addEventListener('blur', nextSelector);
}

refreshSelector();