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

// Toggles
document.querySelectorAll('.toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function (e) {
        e.preventDefault();
        toggle.classList.toggle('expanded');
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


function redirect(url) {
    window.location.href = 'url';
}


function defaultParse(value) { 
    return value == '' || value == null;
}

function validateData(...args) {
    let valid = true;
    
    args.forEach(function (arg) {
        arg.classList.remove('error');
        if (arg.parse == '' || arg.parse == null ? !defaultParse(arg.value) : arg.value.match(arg.parse)) {
            valid = false;
            arg.classList.add('error');
        }
    });
    return valid;
}


window.onload = function() {
    updateDarkmodeButton();
}

