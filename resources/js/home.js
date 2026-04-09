/* resources/js/home.js */
import Swiper from 'swiper/bundle';

document.addEventListener('DOMContentLoaded', () => {
    // Configuração do Swiper (Hero)
    const swiperContainer = document.querySelector('.swiper-hero-banners');

    if (swiperContainer) {
        const slideElements = swiperContainer.querySelectorAll('.swiper-slide');
        const slideCount = slideElements.length;

        if (slideCount > 0) {
            new Swiper(swiperContainer, {
                loop: slideCount > 1,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: slideCount > 1 ? { delay: 6000, disableOnInteraction: false } : false,
                observer: true,
                observeParents: true,
                watchSlidesProgress: true,
                allowTouchMove: false,
                simulateTouch: false
            });
        }
    }

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
                if (!isOpen) closeAllSubmenus();
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