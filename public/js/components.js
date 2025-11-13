// Function to load HTML content
function loadComponent(url, elementId) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        })
        .catch(error => console.error('Error loading component:', error));
}

// Load navbar and footer when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    loadComponent('navbar.html', 'navbar-container');
    loadComponent('footer.html', 'footer-container');
});