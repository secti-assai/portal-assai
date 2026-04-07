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

    function updateNavbar() {
        if (!header) return;

        // Páginas internas: navbar fixa branca com logo preta
        if (!isHomePage) {
            header.classList.remove('bg-transparent', 'text-white', 'border-transparent');
            header.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
            swapLogo(logoBlackSrc, BLACK_LOGO_OFFSET_X);
            return;
        }

        // Home: efeito de scroll transparente → branca
        if (window.scrollY > 50) {
            header.classList.remove('bg-transparent', 'text-white', 'border-transparent');
            header.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
            swapLogo(logoBlackSrc, BLACK_LOGO_OFFSET_X);
        } else {
            header.classList.add('bg-transparent', 'text-white', 'border-transparent');
            header.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
            swapLogo(logoWhiteSrc, WHITE_LOGO_OFFSET_X);
        }
    }

    window.addEventListener('scroll', updateNavbar, { passive: true });
    updateNavbar();

    // ---- 2. MENU MOBILE ----
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    const panel = document.getElementById('mobile-panel');
    const closeBtn = document.getElementById('mobile-close-btn');
    const mobileBtn = document.getElementById('mobile-open-btn');

    function openMenu() {
        if (!drawer || !overlay || !panel) return;
        drawer.classList.remove('invisible');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => {
            overlay.classList.remove('opacity-0');
            panel.classList.remove('translate-x-full');
        });
    }

    function closeMenu() {
        if (!overlay || !panel || !drawer) return;
        overlay.classList.add('opacity-0');
        panel.classList.add('translate-x-full');
        document.body.style.overflow = '';
        setTimeout(() => {
            drawer.classList.add('invisible');
        }, 300);
    }

    if (mobileBtn) mobileBtn.addEventListener('click', openMenu);
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);

    // ---- 3. ACESSIBILIDADE: TAMANHO DA FONTE ----
    const htmlEl = document.documentElement;
    const MIN_SIZE = 14, MAX_SIZE = 20, STEP = 2;

    function getCurrentFontSize() {
        const stored = localStorage.getItem('a11y_fontSize');
        return stored ? parseInt(stored, 10) : 16;
    }

    // Usa querySelectorAll com classe pois há botões em desktop e mobile
    document.querySelectorAll('.btn-increase-font').forEach(btn => {
        btn.addEventListener('click', () => {
            const next = Math.min(getCurrentFontSize() + STEP, MAX_SIZE);
            htmlEl.style.fontSize = next + 'px';
            localStorage.setItem('a11y_fontSize', next);
        });
    });

    document.querySelectorAll('.btn-decrease-font').forEach(btn => {
        btn.addEventListener('click', () => {
            const next = Math.max(getCurrentFontSize() - STEP, MIN_SIZE);
            htmlEl.style.fontSize = next + 'px';
            localStorage.setItem('a11y_fontSize', next);
        });
    });

    // ---- 4. ACESSIBILIDADE: ALTO CONTRASTE ----
    document.querySelectorAll('.btn-contrast').forEach(btn => {
        btn.setAttribute('aria-pressed', htmlEl.classList.contains('contrast-mode') ? 'true' : 'false');
        btn.addEventListener('click', function () {
            htmlEl.classList.toggle('contrast-mode');
            const active = htmlEl.classList.contains('contrast-mode');
            localStorage.setItem('a11y_contrast', active ? '1' : '0');
            document.querySelectorAll('.btn-contrast').forEach(b => {
                b.setAttribute('aria-pressed', active ? 'true' : 'false');
            });
        });
    });

});
