(function() {
    function checkDarkmode() {
        return document.cookie.split('; ').find(row => row.startsWith('darkmode='))?.split('=')[1] === '1';
    }

    if (checkDarkmode()) {
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
})();