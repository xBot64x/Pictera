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
