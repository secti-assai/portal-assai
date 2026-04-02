document.addEventListener('DOMContentLoaded', () => {
    // ---- 1. GESTÃO DO MENU MOBILE ----
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    const panel = document.getElementById('mobile-panel');
    const closeBtn = document.getElementById('mobile-close-btn');
    const mobileBtn = document.getElementById('mobile-open-btn');

    function openMenu() {
        if (!drawer || !overlay || !panel) return;

        drawer.classList.remove('invisible');
        document.body.style.overflow = 'hidden'; // Impede rolagem do fundo

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

    // ---- 2. ACESSIBILIDADE: TAMANHO DA FONTE ----
    const htmlEl = document.documentElement;
    const MIN_SIZE = 14, MAX_SIZE = 20, STEP = 2;

    function getCurrentFontSize() {
        const stored = localStorage.getItem('a11y_fontSize');
        return stored ? parseInt(stored) : 16;
    }

    const btnIncrease = document.getElementById('btn-increase-font');
    if (btnIncrease) {
        btnIncrease.addEventListener('click', () => {
            let next = Math.min(getCurrentFontSize() + STEP, MAX_SIZE);
            htmlEl.style.fontSize = next + 'px';
            localStorage.setItem('a11y_fontSize', next);
        });
    }

    const btnDecrease = document.getElementById('btn-decrease-font');
    if (btnDecrease) {
        btnDecrease.addEventListener('click', () => {
            let next = Math.max(getCurrentFontSize() - STEP, MIN_SIZE);
            htmlEl.style.fontSize = next + 'px';
            localStorage.setItem('a11y_fontSize', next);
        });
    }

    // ---- 3. ACESSIBILIDADE: ALTO CONTRASTE ----
    const btnContrast = document.getElementById('btn-contrast');
    if (btnContrast) {
        // Inicializa o estado do ARIA baseado no carregamento da página
        btnContrast.setAttribute('aria-pressed', htmlEl.classList.contains('contrast-mode') ? 'true' : 'false');

        btnContrast.addEventListener('click', function () {
            htmlEl.classList.toggle('contrast-mode');
            let active = htmlEl.classList.contains('contrast-mode');
            localStorage.setItem('a11y_contrast', active ? '1' : '0');
            this.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }
});
