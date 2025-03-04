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

function likePost(ID_obrazek, likeButton) { // run php likeScript.php
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "includes/likeScript.php?ID_obrazek=" + ID_obrazek, true);
    xmlhttp.send();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let likeCountSpan = likeButton.nextElementSibling;
            let likeCount = parseInt(likeCountSpan.textContent);
            let svgElement = likeButton.querySelector('svg');

            if (svgElement.classList.contains('liked')) {
                svgElement.classList.remove('liked');
                svgElement.innerHTML = '<path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z" />';
                likeCountSpan.textContent = likeCount - 1;
            } else {
                svgElement.classList.add('liked');
                svgElement.innerHTML = '<path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z" />';
                likeCountSpan.textContent = likeCount + 1;
            }
        }
    };
}