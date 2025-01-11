<form class="hidden" id="form-album">
    <h1> Add a new Album </h1>
    <ul>
        <li>
            <label for="input-album_title">Title</label>
            <input type="text" id="input-album_title" name="album_title" required />
        </li>
        <li>
            <label for="input-album_artist">Artist</label>
            <input type="text" id="input-album_artist" name="album_artist" required />
            <datalist id="datalist-album_artists">
                <?php foreach ($artists as $artist): ?>
                    <option id="option-artist_<?php echo $artist['id_artist']; ?>" value="<?php echo $artist['artist']; ?>">
                <?php endforeach; ?>
            </datalist>
        </li>
        <li>
            <label for="input-album_genre">Genre</label>
            <input type="text" id="input-album_genre" name="input-album_genre" required />
        <li>
            <label for="input-album_releasedate">Release Date</label>
            <input type="number" id="input-album_releasedate" name="album_releasedate" required />
        </li>
        <li>
            <label for="input-album_cover">Cover</label>
            <input type="file" id="input-album_cover" name="album_cover" required />
        </li>
    </ul>
    <div class="div"></div>
    <h3>Tracks</h3>
    <ul id="ul-tracks">
        <li class="split">
            <label for="input-track_title_1">Track #1</label>
            <input type="text" id="input-track_title_1" name="track_title" required />
        </li>
        <li class="split">
            <label for="input-track_duration_1">Duration</label>
            <input type="text" id="input-track_duration_1" name="track_duration" required />
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-plus"></i>
                <button class="animate" id="btn-album_submit">Add</button>
            </div>
        </li>
    </ul>
</form>
<script src="/resources/js/album.js"></script>