
function autoRefresh() {
    window.location = window.location.href;
}

function redirect(url) {
    window.location.href = url;
}

// Set client's preferences cookies (so without a expiration date)
function setcookie(name, value) {
    // take varibale name and value
    document.cookie = `${name}=${value}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
}

// Mobile hide keyboard when clicking outside of an input
function isTextInput(node) {
    return ['INPUT', 'TEXTAREA'].indexOf(node.nodeName) !== -1;
}

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
// ADD LINKS TO THE NOTIFICATION
function createNotification(message, status, link = false, icon = false) {
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
    const redlink = document.createElement("a");
    if (link) {
        if (icon) {
            const optIcon = document.createElement("i");
            optIcon.className = icon;
            redlink.appendChild(optIcon);
        }
        const chevronIcon = document.createElement("i");
        chevronIcon.className = "bi bi-caret-right-fill";
        redlink.href = link;
        redlink.appendChild(chevronIcon);
    }
    redlink.ariaHidden = link ? true : false;
    // Assemblaggio del contenuto nel div principale
    mainDiv.appendChild(closeButtonDiv);
    mainDiv.appendChild(statusIcon);
    mainDiv.appendChild(msg);
    mainDiv.appendChild(redlink);

    modal.appendChild(mainDiv);

    mainDiv.classList.add("fade-in");
    closeButton.onclick = function () {
        mainDiv.classList.add("fade-out");
        mainDiv.classList.remove("fade-in");
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
        createNotification(data, true, "/cart", "bi bi-bag-fill");
    }
    ).catch((error) => {
        createNotification(error, false);
    });
}

document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const buttons = form.querySelectorAll('input[type="button"], button[type="button"]');
            if (buttons.length > 0) {
            buttons[buttons.length - 1].click();
            }
        });
    }
});

function getNotificationsRealTime() {
    makeRequest(fetch('/notifications/get')).then((data) => {
        data.forEach(notification => {
            const createdAt = new Date(notification.created_at);
            const now = new Date();
            if (notification.is_read == 0) {
                createNotification(notification.message, true, '/notifications', 'bi bi-bell-fill');
            }
        });
    }
    ).catch((error) => {
    });
}

window.onload = function () {
    updateDarkmodeButton();

    setTimeout(getNotificationsRealTime, 2000);

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

    new MutationObserver(function() {
        const modal = document.querySelector(".modal");
        const items = modal.querySelectorAll("div");
        const firstItem = items[0];
    
        if (firstItem) {
            // Calculate timeout based on the number of items
            const itemCount = items.length;
            const baseTimeout = 2800; // Base timeout in milliseconds
            const minTimeout = 200; // Minimum timeout in milliseconds
            const decayFactor = 0.7; // Decay factor for exponential decay
    
            // Formula: timeout = max(minTimeout, baseTimeout * (decayFactor ^ itemCount))
            let timeout = Math.max(minTimeout, baseTimeout * Math.pow(decayFactor, itemCount));
    
            setTimeout(() => {
                firstItem.classList.add("fade-out");
                firstItem.classList.remove("fade-in");
                setTimeout(() => {
                    firstItem.remove();
                }, 500);
            }, timeout);
        }
    }).observe(document.querySelector('.modal'), { childList: true });
    
}

