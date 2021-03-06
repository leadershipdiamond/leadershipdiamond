(function () {
    var sheet = document.getElementById('style').sheet;

    function addRule(selector, css) {
        var propText = Object.keys(css).map(function (p) {
            return p + ":" + css[p];
        }).join(";");
        if (sheet.cssRules.length) {
            sheet.deleteRule(sheet.cssRules.length - 1);
        }
        sheet.insertRule(selector + "{" + propText + "}", sheet.cssRules.length);
    }
    var nbItems = 5;
    var pad = 20;
    var nav = document.querySelector('.nav-1');
    var navItems = [].slice.call(document.querySelectorAll('.nav-item'));
    var navAction = document.querySelector('.nav-action');
    var size = nav.offsetWidth;
    var ratio = 60 / size;
    var ratioInversed = size / 60;
    window.addEventListener('resize', resize);

    function resize() {
        // get actual size (based on viewport)
        size = nav.offsetWidth;
        // update ratio
        ratio = 60 / size;
        ratioInversed = size / 60;
        // for each item, compute line-height and set font-size
        navItems.map(function (item) {
            item.style.lineHeight = ((size - 2 * pad) / nbItems) + 'px';
            item.style.fontSize = size / 150 + 'em';
        });
        // for ::after elements, compute top
        var top = ratioInversed * 4 - 4;
        addRule(".nav-link::after", {
            transform: 'translateY(' + top + 'px) scaleY(' + ratioInversed + ')'
        });
        updateScales();
    }

    function updateScales() {
        // check if menu is close
        if (nav.classList.contains('is-close')) {
            //nav.style.transform = 'scale(' + ratio + ')';
            nav.style.transform = 'perspective(0px) scale(0.2)';
            navAction.style.transform = 'scale(' + size / 30 + ')';
        } else {
            nav.style.transform = 'scale(1)';
            navAction.style.transform = 'scale(1)';
        }
    }
    var action = document.querySelector('.nav-action');
    action.addEventListener('click', toggleNav);
    //START CUSTOM CODE A LA LARS
    var actionNavLink = document.querySelectorAll('.nav-link');
    for (i = 0; i < actionNavLink.length; i++) {
        actionNavLink[i].addEventListener('click', toggleNav);

    }
//    actionNavLink.forEach(function (NavLink) {});
    //END
    function toggleNav(ev) {
        nav.classList.toggle('is-close');
        updateScales();
    }
    updateScales();
    resize();
})();