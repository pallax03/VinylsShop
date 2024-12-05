/* WORK IN PROGRESS TODO:



// let is_playing = false;
// let what_is_playing = "";

window.onload = function() {
    // let shelf = document.querySelector("div.shelf");

    // // from db to shelf
    // albums.forEach((album) => {
    //     shelf.appendChild(createVinyl(album));
    // });
    loadAnimations();
}

// Create a vinyl from a json album
function createVinyl(json_album) {
    const image_path = "./img/vinyls/"+json_album.image+".webp";
    
    let album = document.createElement("div");
    album.classList.add("album");
    let wrapper = document.createElement("div");
    wrapper.classList.add("vinyl-wrapper");
    let sleeve = document.createElement("div");
    sleeve.classList.add("sleeve");
    let vinyl = document.createElement("div");
    vinyl.classList.add("vinyl");

    sleeve.style.backgroundImage = `url(${image_path})`;
    vinyl.style.backgroundImage = `url(${image_path})`;

    // Get color from image with ColorThief
    let img = new Image();
    img.src = image_path;
    img.onload = function() {
        let colorThief = new ColorThief();
        let color = colorThief.getColor(img);
        let palette = colorThief.getPalette(img);
        vinyl.style.borderColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
        let boxShadow = (main_color, border_color) => {return `0px 0px 3px ${main_color}, 0px 0px 0px 10px ${border_color}, 0px 0px 15px ${main_color}, 0px 0px 0px 16px #000, 0px 0px 0px 17px #252424, 0px 0px 0px 18px #000, 0px 0px 0px 19px #313030, 0px 0px 0px 20px #000, 0px 0px 0px 21px #3a3838, 0px 0px 0px 22px #000, 0px 0px 0px 23px #2b2a2a, 0px 0px 0px 24px #000, 0px 0px 0px 25px #313030, 0px 0px 0px 26px #000, 0px 0px 0px 27px #313030, 0px 0px 0px 28px #000, 0px 0px 0px 29px #333333, 0px 0px 0px 30px #000, 0px 0px 0px 31px #333232, 0px 0px 0px 32px #000, 0px 0px 0px 33px #4c4a4a, 0px 0px 0px 34px #000, 0px 0px 0px 35px #2f2e2e, 0px 0px 0px 36px #000, 0px 0px 0px 37px #252424, 0px 0px 0px 38px #000, 0px 0px 0px 39px #2f2e2e, 0px 0px 0px 40px #000, 0px 0px 0px 41px #2f2e2e, 0px 0px 0px 42px #000, 0px 0px 0px 55px #2f2e2e, 0px 0px 0px 56px #000, 0px 0px 0px 57px #2f2e2e, 0px 0px 0px 58px #cecece, 0px 0px 12px 59px #2f2e2e`};
        vinyl.style.boxShadow = boxShadow(`rgb(${color[0]}, ${color[1]}, ${color[2]})`, `rgb(${palette[0][0]}, ${palette[0][1]}, ${palette[0][2]})`);
        album.style.color = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
    }
    if (img.complete) {
        img.onload();
    }
    
    let title = document.createElement("h3");
    title.textContent = json_album.title;
    let artist = document.createElement("p");
    artist.textContent = json_album.artist;
    let price = document.createElement("p");
    price.textContent = json_album.price;

    wrapper.appendChild(sleeve);
    wrapper.appendChild(vinyl);
    album.appendChild(wrapper);
    album.appendChild(title);
    album.appendChild(artist);
    album.appendChild(price);
    return album;
}


function loadAnimations() {
    document.querySelectorAll("div.vinyl-wrapper").forEach((album) => album.addEventListener("click", function() {
        let vinyl = album.querySelector("div.vinyl")
        selectAlbum(vinyl);
        resetAlbums();
        setTimeout(resetAlbums, (parseFloat(window.getComputedStyle(vinyl).animationDuration)*1000)-50);
    }));
}

let selectAlbum = (vinyl) => {
    if (!vinyl.classList.contains("spin")) {
        vinyl.classList.remove("pull-in");
        vinyl.classList.add("pull-out");
        let audio = new Audio("/assets/sound/Turntable.mp3");
        audio.volume = 0.2;
        audio.play();
    }
    vinyl.addEventListener('animationend', function() {
        if (vinyl.classList.contains("pull-out")) {
            vinyl.classList.add("spin");
        } else if (vinyl.classList.contains("pull-in")) {
            vinyl.classList.remove("pull-in");
            vinyl.classList.remove("spin");
        }
    });
    what_is_playing = vinyl.id;
    is_playing = !is_playing;
};

let resetAlbums = () => {
    document.querySelectorAll("div.vinyl-wrapper").forEach((album) => {
        let vinyl = album.querySelector("div.vinyl");
        if(vinyl.classList.contains("spin")) {
            vinyl.classList.remove("spin");
            vinyl.classList.remove("pull-out");
            vinyl.classList.add("pull-in");
        }
    });
    is_playing = false;
};
*/