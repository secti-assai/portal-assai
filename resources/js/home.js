import Swiper from 'swiper/bundle';

window.Swiper = Swiper;

// =============================================================================
// MENU MOBILE
// =============================================================================
document.addEventListener('DOMContentLoaded', function () {
    if (window.innerWidth > 1023) return;

    var wrapper = document.getElementById('home-main');
    if (wrapper && wrapper.parentElement) {
        wrapper.parentElement.style.setProperty('padding-top', '0px', 'important');
        wrapper.parentElement.style.setProperty('margin-top', '0px', 'important');
    }

    var root    = document.getElementById('pl-mobile-home');
    var trigger = document.getElementById('mobile-menu-trigger');
    var drawer  = document.getElementById('mobile-drawer-nav');
    var toggles = drawer ? drawer.querySelectorAll('.mobile-nav-toggle') : [];

    if (!root || !trigger || !drawer) return;

    function syncDrawerLayout() {
        var topbar = root.querySelector('.topbar');
        if (!topbar) return;
        root.style.setProperty('--pl-mobile-topbar-height', Math.ceil(topbar.getBoundingClientRect().height) + 'px');
    }

    function closeAllSubmenus() {
        drawer.querySelectorAll('.mobile-nav-group.open').forEach(function (group) {
            group.classList.remove('open');
            var btn = group.querySelector('.mobile-nav-toggle');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        });
    }

    function setMenuState(isOpen) {
        root.classList.toggle('menu-open', isOpen);
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        drawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

        if (isOpen) {
            drawer.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-2');
            drawer.classList.add('opacity-100', 'translate-y-0');
            if (window.innerWidth < 768) document.body.style.overflow = 'hidden';
        } else {
            drawer.classList.add('opacity-0', 'pointer-events-none', '-translate-y-2');
            drawer.classList.remove('opacity-100', 'translate-y-0');
            document.body.style.overflow = '';
            closeAllSubmenus();
        }
    }

    syncDrawerLayout();
    window.addEventListener('resize', syncDrawerLayout, { passive: true });
    trigger.addEventListener('click', function () { setMenuState(!root.classList.contains('menu-open')); });

    toggles.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var group = btn.closest('.mobile-nav-group');
            if (!group) return;
            var willOpen = !group.classList.contains('open');
            closeAllSubmenus();
            if (willOpen) {
                group.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    drawer.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () { setMenuState(false); });
    });

    document.addEventListener('click', function (event) {
        if (!root.classList.contains('menu-open')) return;
        if (!drawer.contains(event.target) && !trigger.contains(event.target)) {
            setMenuState(false);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && root.classList.contains('menu-open')) setMenuState(false);
    });
});

// =============================================================================
// SWIPER — FIQUE LIGADO
// =============================================================================
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.swiper-fique-ligado').forEach(function (el) {
        if (el.offsetParent === null) return;

        var slides = el.querySelectorAll('.swiper-slide').length;
        if (slides === 0) return;

        var canLoop = slides > 1;

        new Swiper(el, {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: canLoop,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: canLoop ? { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: false } : false,
            observer: true,
            observeParents: true,
            watchOverflow: true,
            allowTouchMove: true,
            simulateTouch: true,
            pagination: {
                el: el.parentElement.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: el.parentElement.querySelector('.swiper-button-next'),
                prevEl: el.parentElement.querySelector('.swiper-button-prev'),
            },
        });
    });
});

// =============================================================================
// CALENDARIO — AJAX (mobile + desktop)
// O mes inicial e lido do atributo data-mes do wrapper, injetado pelo Blade.
// =============================================================================
document.addEventListener('DOMContentLoaded', function () {

    function renderMobileDays(grid, dias) {
        var html = "<span class='day-name'>D</span><span class='day-name'>S</span>"
                 + "<span class='day-name'>T</span><span class='day-name'>Q</span>"
                 + "<span class='day-name'>Q</span><span class='day-name'>S</span>"
                 + "<span class='day-name'>S</span>";
        dias.forEach(function (day) {
            var cls = 'day-number';
            if (!day.isCurrentMonth) cls += ' muted';
            if (day.isToday)         cls += ' today';
            if (day.hasEvent)        cls += ' event';
            html += '<span class="' + cls + '">' + day.day + '</span>';
        });
        grid.innerHTML = html;
    }

    function renderDesktopDays(grid, dias) {
        var html = '';
        dias.forEach(function (day) {
            var cls = 'w-10 h-10 flex items-center justify-center mx-auto rounded-full text-base font-medium ';
            cls += day.isCurrentMonth ? 'text-[#334155] ' : 'text-[#cbd5e1] ';
            if (day.isToday)  cls += 'border-2 border-[#14b8a6] ';
            if (day.hasEvent) cls += 'bg-[#64748b] text-white font-bold ';
            html += '<span class="' + cls + '">' + day.day + '</span>';
        });
        grid.innerHTML = html;
    }

    function initCalendar(opts) {
        var wrap = document.getElementById(opts.wrapperId);
        if (!wrap) return;

        var currentMonth = wrap.dataset.mes;
        var prevBtn      = document.getElementById(opts.prevId);
        var nextBtn      = document.getElementById(opts.nextId);
        var monthName    = document.getElementById(opts.monthNameId);
        var daysGrid     = document.getElementById(opts.daysGridId);

        if (!prevBtn || !nextBtn || !monthName || !daysGrid) return;

        function updateCalendar(mes) {
            fetch('/api/calendario?mes=' + mes)
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    monthName.textContent = data.tituloMes;
                    opts.renderDays(daysGrid, data.dias);
                    currentMonth = data.mes;
                    wrap.dataset.mes = data.mes;
                })
                .catch(function (err) {
                    console.warn('[Calendario] Erro ao atualizar:', err);
                });
        }

        function navMonth(dir) {
            fetch('/api/calendario-prev-next?mes=' + currentMonth + '&dir=' + dir)
                .then(function (res) { return res.json(); })
                .then(function (data) { updateCalendar(data.mes); })
                .catch(function (err) {
                    console.warn('[Calendario] Erro de navegacao:', err);
                });
        }

        prevBtn.addEventListener('click', function () { navMonth('prev'); });
        nextBtn.addEventListener('click', function () { navMonth('next'); });
    }

    // Mobile
    initCalendar({
        wrapperId:   'calendar-ajax-wrap',
        prevId:      'calendar-prev-btn',
        nextId:      'calendar-next-btn',
        monthNameId: 'calendar-month-name',
        daysGridId:  'calendar-days-grid',
        renderDays:  renderMobileDays,
    });

    // Desktop
    initCalendar({
        wrapperId:   'calendar-desktop-wrap',
        prevId:      'calendar-desktop-prev',
        nextId:      'calendar-desktop-next',
        monthNameId: 'calendar-desktop-month',
        daysGridId:  'calendar-desktop-days',
        renderDays:  renderDesktopDays,
    });
});