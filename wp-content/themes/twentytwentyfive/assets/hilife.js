(function() {
    function initHamburger() {
        var hamburger = document.getElementById('hilife-hamburger');
        var nav = document.getElementById('hilife-nav');
        if (!hamburger || !nav) return;
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('is-active');
            nav.classList.toggle('is-open');
        });
        document.addEventListener('click', function(e) {
            if (!hamburger.contains(e.target) && !nav.contains(e.target)) {
                hamburger.classList.remove('is-active');
                nav.classList.remove('is-open');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHamburger);
    } else {
        initHamburger();
    }
})();
