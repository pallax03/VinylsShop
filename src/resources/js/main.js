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

document.addEventListener('touchstart', function (e) {
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
    return window.getComputedStyle(document.querySelector('body'), null).getPropertyValue('--background-color') !== '#fff' ? 1 : 0;
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
    window.location.href = url;
}


function defaultParse(value) {
    return value == '' || value == null;
}

function validateData(...args) {
    let valid = true;

    args.forEach(function (arg) {
        arg.classList.remove('error');
        if (arg.parse == null || arg.parse == '' ? defaultParse(arg.value) : !arg.value.match(arg.parse)) {
            valid = false;
            arg.classList.add('error');
        }
    });
    return valid;
}

let timeout = false;
function createNotification(message, status) {
    const modal = document.querySelector(".modal");
    const mainDiv = document.createElement("div");

    const closeButtonDiv = document.createElement("div");
    const closeButton = document.createElement("button");
    const closeIcon = document.createElement("i");
    closeIcon.className = "bi bi-x-circle-fill";
    closeButton.appendChild(closeIcon);
    closeButtonDiv.appendChild(closeButton);

    // Creazione dell'icona di stato
    const statusIcon = document.createElement("i");
    statusIcon.className = status ? "bi bi-check-circle" : "bi bi-x-circle";

    // Creazione del messaggio
    const msg = document.createElement("p");
    msg.textContent = message;

    // Creazione del link con icone
    const link = document.createElement("a");
    const bagIcon = document.createElement("i");
    bagIcon.className = "bi bi-bag-fill";
    const chevronIcon = document.createElement("i");
    chevronIcon.className = "bi bi-chevron-double-right";
    link.appendChild(bagIcon);
    link.appendChild(chevronIcon);

    // Assemblaggio del contenuto nel div principale
    mainDiv.appendChild(closeButtonDiv);
    mainDiv.appendChild(statusIcon);
    mainDiv.appendChild(msg);
    mainDiv.appendChild(link);

    modal.appendChild(mainDiv);

    mainDiv.classList.add("fade-in");
    closeButton.onclick = function () {
        mainDiv.classList.add("fade-out");
        mainDiv.classList.remove("fade-in");
        mainDiv.ariaHidden = true;
        setTimeout(() => {
            modal.removeChild(mainDiv);
        }, 500);
    }
}

async function makeRequest(fetch) {
    const response = await fetch;
    const data = await response.json();
    if (!response.ok) {
        throw data.error;
    }
    return data.message;
}
    

function addToCart(id, quantity) {
    makeRequest(fetch('/cart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_vinyl: id, quantity: quantity })
    })).then((data) => {
        try {
            getCart();
        } catch (error) {}
        createNotification(data, true);
    }
    ).catch((error) => {
        createNotification(error, false);
    });
}

document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        const activeElement = document.activeElement;
        if (activeElement && activeElement.tagName === 'INPUT' && activeElement.type !== 'submit') {
            const form = activeElement.form;
            if (form) {
                const submitButton = form.querySelector('button, input[type="button"]');
                if (submitButton) {
                    submitButton.click();
                }
            }
        }
    }
});

window.onload = function () {
    updateDarkmodeButton();
}

