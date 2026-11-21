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

/* Hero parallax: .hilife-hero-media moves at ~0.3x scroll speed.
   Off for reduced motion and below 768px (image stays static, fade still applies). */
(function() {
    var SPEED = 0.3;
    var OVERSCAN = 0.12; // must match top/bottom: -12% on .hilife-hero-media
    var MIN_WIDTH = 768;

    function initParallax() {
        var media = Array.prototype.slice.call(document.querySelectorAll('.hilife-hero-media'));
        if (!media.length) return;

        var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)');
        var ticking = false;
        var active = false;

        function enabled() {
            return !(reduceMotion && reduceMotion.matches) && window.innerWidth >= MIN_WIDTH;
        }

        function update() {
            ticking = false;
            var vh = window.innerHeight;
            for (var i = 0; i < media.length; i++) {
                var hero = media[i].parentElement;
                if (!hero) continue;
                var rect = hero.getBoundingClientRect();
                if (rect.bottom <= 0 || rect.top >= vh) continue; // off-screen
                var max = rect.height * OVERSCAN;
                var y = -rect.top * SPEED;
                if (y > max) y = max;
                if (y < -max) y = -max;
                media[i].style.transform = 'translate3d(0,' + y.toFixed(2) + 'px,0)';
            }
        }

        function requestUpdate() {
            if (!active || ticking) return;
            ticking = true;
            window.requestAnimationFrame(update);
        }

        function reset() {
            for (var i = 0; i < media.length; i++) media[i].style.transform = '';
        }

        function refresh() {
            var shouldBeActive = enabled();
            if (shouldBeActive !== active) {
                active = shouldBeActive;
                if (!active) reset();
            }
            requestUpdate();
        }

        window.addEventListener('scroll', requestUpdate, { passive: true });
        window.addEventListener('resize', refresh, { passive: true });
        window.addEventListener('load', refresh);
        if (reduceMotion && reduceMotion.addEventListener) {
            reduceMotion.addEventListener('change', refresh);
        }
        refresh();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initParallax);
    } else {
        initParallax();
    }
})();
