// debugging front end
function autoRefresh() {
    window.location = window.location.href;
}
// setInterval(autoRefresh, 5000);

// Set client's preferences cookies (so without a expiration date)
function setcookie(name, value) {
    // take varibale name and value
    document.cookie = `${name}=${value}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
}

// Mobile hide keyboard when clicking outside of an input
function isTextInput(node) {
    return ['INPUT', 'TEXTAREA'].indexOf(node.nodeName) !== -1;
}

document.addEventListener('touchstart', function(e) {
    if (!isTextInput(e.target) && isTextInput(document.activeElement)) {
        document.activeElement.blur();
    }
}, false);

// Search bar
document.querySelector('.search').addEventListener('click', function (e) {
    e.preventDefault();
    const searchContainer = this.closest('.search-container');
    searchContainer.classList.toggle('active');
    document.querySelectorAll('nav ul li').forEach(function (li) {
        if (!(li.classList.contains('search-container'))) {
            li.classList.toggle('hide-item');
        }
    });
});

document.querySelector('.close-search').addEventListener('click', function (e) {
    e.preventDefault();
    const searchContainer = this.closest('.search-container');
    searchContainer.classList.remove('active');

    document.querySelectorAll('nav ul li').forEach(function (li) {
        if (!li.classList.contains('search-container')) {
            li.classList.toggle('hide-item');
        }
    });
});


// Toggles
document.querySelectorAll('.toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function (e) {
        e.preventDefault();
        toggle.classList.toggle('active');
    });
});


// Darkmode
document.querySelector('#btn-darkmode').addEventListener('click', function (e) {
    e.preventDefault();
    setcookie('darkmode', setDarkmode());
});

function checkDarkmode() {
    return window.getComputedStyle(document.querySelector('body') ,null).getPropertyValue('--background-color') !== '#fff' ? 1 : 0;
}
function setDarkmode() {
    if (!checkDarkmode()) {
        document.documentElement.style.setProperty('--secondary-color', '#000');
        document.documentElement.style.setProperty('--text-color', '#fff');
        document.documentElement.style.setProperty('--background-color', '#333');
        document.documentElement.style.setProperty('--border-color', '#fff');
    } else {
        document.documentElement.style.setProperty('--secondary-color', '#fff');
        document.documentElement.style.setProperty('--text-color', '#000');
        document.documentElement.style.setProperty('--background-color', '#fff');
        document.documentElement.style.setProperty('--border-color', '#000');
    }
    updateDarkmodeButton();
    return checkDarkmode();
}

function updateDarkmodeButton() {
    document.getElementById('btn-darkmode').classList.toggle('active', checkDarkmode());
}

window.onload = function() {
    updateDarkmodeButton();
}