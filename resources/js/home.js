import Swiper from 'swiper/bundle';

// Expõe estritamente a variável global para acesso do script Vanilla no arquivo blade
window.Swiper = Swiper;

document.addEventListener('DOMContentLoaded', () => {
    // =========================================================================
    // LÓGICA DO MENU MOBILE (Pedro Leopoldo Style) E CORREÇÕES DO LARAVEL
    // =========================================================================
    if (window.innerWidth <= 1023) {
        // Remove margens indesejadas na raiz do html
        const wrapper = document.getElementById("home-main");
        if (wrapper && wrapper.parentElement) {
            wrapper.parentElement.style.setProperty('padding-top', '0px', 'important');
            wrapper.parentElement.style.setProperty('margin-top', '0px', 'important');
        }

        // Script do Menu Mobile Drawer
        const root = document.getElementById('pl-mobile-home');
        const trigger = document.getElementById('mobile-menu-trigger');
        const drawer = document.getElementById('mobile-drawer-nav');
        const toggles = drawer ? drawer.querySelectorAll('.mobile-nav-toggle') : [];

        if (root && trigger && drawer) {
            const syncDrawerLayout = () => {
                const topbar = root.querySelector('.topbar');
                if (!topbar) return;

                const topbarHeight = Math.ceil(topbar.getBoundingClientRect().height);
                root.style.setProperty('--pl-mobile-topbar-height', `${topbarHeight}px`);
            };

            const closeAllSubmenus = () => {
                drawer.querySelectorAll('.mobile-nav-group.open').forEach((group) => {
                    group.classList.remove('open');
                    const btn = group.querySelector('.mobile-nav-toggle');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                });
            };

            const setMenuState = (isOpen) => {
                root.classList.toggle('menu-open', isOpen);
                trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                drawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

                if (isOpen) {
                    drawer.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-2');
                    drawer.classList.add('opacity-100', 'translate-y-0');
                    if (window.innerWidth < 768) {
                        document.body.style.overflow = 'hidden';
                    }
                } else {
                    drawer.classList.add('opacity-0', 'pointer-events-none', '-translate-y-2');
                    drawer.classList.remove('opacity-100', 'translate-y-0');
                    document.body.style.overflow = '';
                    closeAllSubmenus();
                }
            };

            const openMenu = () => setMenuState(true);
            const closeMenu = () => setMenuState(false);
            const toggleMenu = () => setMenuState(!root.classList.contains('menu-open'));

            syncDrawerLayout();
            window.addEventListener('resize', syncDrawerLayout, { passive: true });

            trigger.addEventListener('click', toggleMenu);

            toggles.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const group = btn.closest('.mobile-nav-group');
                    if (!group) return;

                    const willOpen = !group.classList.contains('open');
                    closeAllSubmenus();

                    if (willOpen) {
                        group.classList.add('open');
                        btn.setAttribute('aria-expanded', 'true');
                    }
                });
            });

            drawer.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', closeMenu);
            });

            document.addEventListener('click', (event) => {
                if (!root.classList.contains('menu-open')) return;

                const clickedInsideMenu = drawer.contains(event.target);
                const clickedTrigger = trigger.contains(event.target);

                if (!clickedInsideMenu && !clickedTrigger) closeMenu();
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && root.classList.contains('menu-open')) closeMenu();
            });
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const fiqueLigadoSwipers = document.querySelectorAll('.swiper-fique-ligado');

    fiqueLigadoSwipers.forEach(function (swiperElement) {
        if (swiperElement.offsetParent === null) {
            return;
        }

        const slideCount = swiperElement.querySelectorAll('.swiper-slide').length;
        if (slideCount === 0) {
            return;
        }

        const canLoop = slideCount > 1;

        new Swiper(swiperElement, {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: canLoop,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            autoplay: canLoop
                ? {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false,
                }
                : false,
            observer: true,
            observeParents: true,
            watchOverflow: true,
            allowTouchMove: false,
            simulateTouch: false,
            pagination: {
                el: swiperElement.querySelector('.swiper-pagination'),
                clickable: false,
            },
            navigation: {
                nextEl: swiperElement.querySelector('.swiper-button-next'),
                prevEl: swiperElement.querySelector('.swiper-button-prev'),
            },
        });
    });
});