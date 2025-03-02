// On page load
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.dropdown > div').forEach(dropdownToggle => {
        dropdownToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            this.nextElementSibling.classList.toggle('show');
        });
    });

    window.addEventListener('click', function(event) {
        document.querySelectorAll('.dropdown-content').forEach(dropdownContent => {
            if (dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
            }
        });
    });
});

function generatelink(element, text) {
    navigator.clipboard.writeText(text);

    let originalText = element.textContent;
    element.textContent = "Zkopírováno!";

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