/* resources/js/home.js */
import Swiper from 'swiper/bundle';

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
});