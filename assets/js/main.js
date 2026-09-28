(function () {
    'use strict';

    var toggle = document.querySelector('.nav-toggle');
    var nav = document.getElementById('site-navigation');

    if (!toggle || !nav) {
        return;
    }

    function setOpen(open) {
        document.body.classList.toggle('nav-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    toggle.addEventListener('click', function () {
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    nav.addEventListener('click', function (event) {
        if (event.target.closest('a')) {
            setOpen(false);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && document.body.classList.contains('nav-open')) {
            setOpen(false);
            toggle.focus();
        }
    });

    window.matchMedia('(min-width: 901px)').addEventListener('change', function (mq) {
        if (mq.matches) {
            setOpen(false);
        }
    });
})();
