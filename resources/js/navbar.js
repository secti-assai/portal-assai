/**
 * ==========================================================================
 * PORTAL PREFEITURA MUNICIPAL DE ASSAÍ — navbar.js
 * Lógica da Navbar: Menu Mobile, Scroll, Logo e Acessibilidade
 *
 * Lê a configuração do elemento #portal-config (renderizado pelo Blade)
 * via data-attributes, eliminando qualquer dependência de Blade inline.
 * ==========================================================================
 */

document.addEventListener('DOMContentLoaded', () => {

    const safeStorageGet = (key) => {
        try {
            return window.localStorage.getItem(key);
        } catch (e) {
            return null;
        }
    };

    const safeStorageSet = (key, value) => {
        try {
            window.localStorage.setItem(key, value);
            return true;
        } catch (e) {
            return false;
        }
    };

    // ---- CONFIGURAÇÃO (via data-attributes do #portal-config) ----
    const config = document.getElementById('portal-config');
    const isHomePage = config?.dataset.isHome === 'true';
    const logoWhiteSrc = config?.dataset.logoWhite || '';
    const logoBlackSrc = config?.dataset.logoBlack || '';

    // ---- 1. SCROLL DA NAVBAR & TROCA DE LOGO ----
    const header = document.getElementById('site-header');
    const logo = document.getElementById('nav-logo-img');

    const WHITE_LOGO_OFFSET_X = 0;
    const BLACK_LOGO_OFFSET_X = 6;
    const desktopMq = window.matchMedia('(min-width: 1024px)');
    const heroSection = document.getElementById('hero-oficial');
    let lastHeaderHeight = 0;
    const homeTransparentDesktopClasses = [
        'lg:bg-transparent',
        'lg:backdrop-blur-none',
        'lg:shadow-none',
        'lg:text-white',
        'lg:border-transparent'
    ];

    function isDesktopViewport() {
        return desktopMq.matches;
    }

    function syncHeaderHeightVar() {
        if (!header) return;

        const nextHeight = Math.ceil(header.getBoundingClientRect().height);
        if (nextHeight <= 0 || nextHeight === lastHeaderHeight) return;

        document.documentElement.style.setProperty('--site-header-height', `${nextHeight}px`);
        lastHeaderHeight = nextHeight;
    }

    function swapLogo(nextSrc, offsetX) {
        if (!logo || !nextSrc) return;
        const currentSrc = logo.getAttribute('src') || '';
        if (currentSrc === nextSrc) {
            logo.style.transform = `translateX(${offsetX}px)`;
            return;
        }
        logo.style.opacity = '0';
        const reveal = () => {
            logo.style.transform = `translateX(${offsetX}px)`;
            logo.style.opacity = '1';
            logo.removeEventListener('load', reveal);
        };
        logo.addEventListener('load', reveal, { once: true });
        logo.src = nextSrc;
        setTimeout(() => {
            logo.style.transform = `translateX(${offsetX}px)`;
            logo.style.opacity = '1';
        }, 140);
    }

    function getHeroScrollThreshold() {
        // Home desktop: transparente apenas no topo absoluto da página.
        return 0;
    }

    function updateNavbar() {
        if (!header) return;
        syncHeaderHeightVar();

        // Páginas internas: navbar fixa branca com logo preta
        if (!isHomePage) {
            header.classList.remove('bg-transparent', 'text-white', 'border-transparent');
            header.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
            swapLogo(logoBlackSrc, BLACK_LOGO_OFFSET_X);
            return;
        }

        // Home mobile/tablet: mantém navbar sólida para legibilidade
        if (!isDesktopViewport()) {
            header.classList.remove('bg-transparent', 'text-white', 'border-transparent');
            header.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
            swapLogo(logoBlackSrc, BLACK_LOGO_OFFSET_X);
            return;
        }

        // Home desktop: efeito de scroll transparente → branca considerando a altura da hero.
        if (window.scrollY > getHeroScrollThreshold()) {
            header.classList.remove(...homeTransparentDesktopClasses);
            header.classList.remove('bg-transparent', 'text-white', 'border-transparent');
            header.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
            swapLogo(logoBlackSrc, BLACK_LOGO_OFFSET_X);
        } else {
            header.classList.add(...homeTransparentDesktopClasses);
            header.classList.add('bg-transparent', 'text-white', 'border-transparent');
            header.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
            swapLogo(logoWhiteSrc, WHITE_LOGO_OFFSET_X);
        }
    }

    window.addEventListener('scroll', updateNavbar, { passive: true });
    desktopMq.addEventListener('change', updateNavbar);
    window.addEventListener('resize', updateNavbar, { passive: true });
    syncHeaderHeightVar();
    updateNavbar();

    // ---- 2. MENU MOBILE ----
    const mobileTrigger = document.getElementById('mobile-menu-trigger');
    const mobileDropdown = document.getElementById('mobile-drawer-nav');
    const mobileGroups = mobileDropdown ? mobileDropdown.querySelectorAll('.mobile-nav-group') : [];

    if (mobileTrigger && mobileDropdown) {
        const openCls = ['opacity-100', 'visible', 'pointer-events-auto'];
        const closedCls = ['opacity-0', 'invisible', 'pointer-events-none'];

        const closeAllSubmenus = () => {
            mobileGroups.forEach((group) => {
                group.classList.remove('open');
                const btn = group.querySelector('.mobile-nav-toggle');
                const caret = group.querySelector('.caret');
                const submenu = group.querySelector('.mobile-submenu');
                if (btn) btn.setAttribute('aria-expanded', 'false');
                if (caret) caret.classList.remove('rotate-180');
                if (submenu) submenu.classList.add('hidden');
            });
        };

        const setMenuState = (isOpen) => {
            mobileTrigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            mobileDropdown.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

            mobileDropdown.classList.remove(...(isOpen ? closedCls : openCls));
            mobileDropdown.classList.add(...(isOpen ? openCls : closedCls));

            const iconOpen = mobileTrigger.querySelector('.icon-open');
            const iconClose = mobileTrigger.querySelector('.icon-close');
            if (iconOpen) iconOpen.classList.toggle('hidden', isOpen);
            if (iconClose) iconClose.classList.toggle('hidden', !isOpen);

            if (!isOpen) closeAllSubmenus();
        };

        const toggleMenu = () => {
            const isOpen = mobileTrigger.getAttribute('aria-expanded') === 'true';
            setMenuState(!isOpen);
        };

        mobileTrigger.addEventListener('click', toggleMenu);

        mobileGroups.forEach((group) => {
            const btn = group.querySelector('.mobile-nav-toggle');
            if (!btn) return;

            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-submenu-target');
                const submenu = targetId ? document.getElementById(targetId) : null;
                const caret = group.querySelector('.caret');
                const willOpen = !group.classList.contains('open');

                closeAllSubmenus();

                if (willOpen && submenu) {
                    group.classList.add('open');
                    btn.setAttribute('aria-expanded', 'true');
                    submenu.classList.remove('hidden');
                    if (caret) caret.classList.add('rotate-180');
                }
            });
        });

        mobileDropdown.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenuState(false));
        });

        document.addEventListener('click', (event) => {
            const isOpen = mobileTrigger.getAttribute('aria-expanded') === 'true';
            if (!isOpen) return;
            const insideDropdown = mobileDropdown.contains(event.target);
            const insideTrigger = mobileTrigger.contains(event.target);
            if (!insideDropdown && !insideTrigger) setMenuState(false);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && mobileTrigger.getAttribute('aria-expanded') === 'true') {
                setMenuState(false);
            }
        });
    }

    // Fallback legado: gaveta lateral antiga (caso alguma página ainda use)
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    const panel = document.getElementById('mobile-panel');
    const closeBtn = document.getElementById('mobile-close-btn');
    const mobileBtn = document.getElementById('mobile-open-btn');

    if (drawer && overlay && panel && mobileBtn) {
        function openMenu() {
            drawer.classList.remove('invisible');
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                panel.classList.remove('translate-x-full');
            });
        }

        function closeMenu() {
            overlay.classList.add('opacity-0');
            panel.classList.add('translate-x-full');
            document.body.style.overflow = '';
            setTimeout(() => {
                drawer.classList.add('invisible');
            }, 300);
        }

        mobileBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    }

    // ---- 3. ACESSIBILIDADE: TAMANHO DA FONTE ----
    const htmlEl = document.documentElement;
    const MIN_SIZE = 14, MAX_SIZE = 20, STEP = 2;

    function getCurrentFontSize() {
        const stored = safeStorageGet('a11y_fontSize');
        return stored ? parseInt(stored, 10) : 16;
    }

    // Usa querySelectorAll com classe pois há botões em desktop e mobile
    document.querySelectorAll('.btn-increase-font').forEach(btn => {
        btn.addEventListener('click', () => {
            const next = Math.min(getCurrentFontSize() + STEP, MAX_SIZE);
            htmlEl.style.fontSize = next + 'px';
            safeStorageSet('a11y_fontSize', String(next));
        });
    });

    document.querySelectorAll('.btn-decrease-font').forEach(btn => {
        btn.addEventListener('click', () => {
            const next = Math.max(getCurrentFontSize() - STEP, MIN_SIZE);
            htmlEl.style.fontSize = next + 'px';
            safeStorageSet('a11y_fontSize', String(next));
        });
    });

    // ---- 4. ACESSIBILIDADE: ALTO CONTRASTE ----
    document.querySelectorAll('.btn-contrast').forEach(btn => {
        btn.setAttribute('aria-pressed', htmlEl.classList.contains('contrast-mode') ? 'true' : 'false');
        btn.addEventListener('click', function () {
            htmlEl.classList.toggle('contrast-mode');
            const active = htmlEl.classList.contains('contrast-mode');
            safeStorageSet('a11y_contrast', active ? '1' : '0');
            document.querySelectorAll('.btn-contrast').forEach(b => {
                b.setAttribute('aria-pressed', active ? 'true' : 'false');
            });
        });
    });

});
