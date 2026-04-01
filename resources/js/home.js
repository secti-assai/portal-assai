/* resources/js/home.js */
import Swiper from 'swiper/bundle';

// Importante: O Swiper 11 já inclui todos os módulos no bundle.
// Não é necessário importar Navigation ou Pagination separadamente se usar o bundle.

document.addEventListener('DOMContentLoaded', () => {
    const slideElements = document.querySelectorAll('.swiper-banners .swiper-slide');
    const slideCount = slideElements.length;

    if (slideCount === 0) return;

    const swiper = new Swiper('.swiper-banners', {
        loop: slideCount > 1,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: slideCount > 1 ? { delay: 6000, disableOnInteraction: false } : false,
        pagination: { 
            el: '.swiper-pagination', 
            clickable: true 
        },
        navigation: { 
            nextEl: '.banner-next', 
            prevEl: '.banner-prev' 
        },
        observer: true,
        observeParents: true,
        watchSlidesProgress: true,
        allowTouchMove: slideCount > 1 
    });

    // Função de ajuste de layout
    function fixLayoutHeight() {
        const hero = document.getElementById('home-hero');
        const header = document.getElementById('site-header');

        if (header) {
            const headerHeight = header.offsetHeight;
            document.body.style.paddingTop = `${headerHeight}px`;

            if (hero) {
                hero.style.height = `calc(100dvh - ${headerHeight}px)`;
            }
        }
    }

    window.addEventListener('load', fixLayoutHeight);
    window.addEventListener('resize', fixLayoutHeight);
    fixLayoutHeight();
});