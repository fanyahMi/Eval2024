window.addEventListener('load', function load() {
    const loader = document.getElementById('loader');
    setTimeout(function() {
        loader.classList.add('fadeOut');
    }, 300);
});

window.addEventListener('load', function() {
    if (localStorage.getItem('etapesData')) {
        localStorage.removeItem('etapesData');
    }
});
