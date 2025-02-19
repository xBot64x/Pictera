// On page load
document.addEventListener('DOMContentLoaded', (event) => {
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }
});

function generatelink(element, text) {
    // Copy the text inside the text field
    navigator.clipboard.writeText(text);

    // Change the text to "zkopírováno!"
    let originalText = element.textContent;
    element.textContent = "Zkopírováno!";

    // Change the text back to "sdílet" after 1 second
    setTimeout(() => {
        element.textContent = originalText;
    }, 1000);
}

function hidepopup() {
    document.getElementById('notification').style.display = 'none';
    setCookie("hidepopup", "1", 1);
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function showHeaderDropdown() {
    event.stopPropagation();
    document.getElementById('headerDropdown').classList.toggle('show');
}

window.onclick = function(event) {
    if (!event.target.matches('.navimage')) {
        let dropdowns = document.getElementsByClassName('dropdown-content');
        for (let i = 0; i < dropdowns.length; i++) {
            let openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}