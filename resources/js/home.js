/* resources/js/home.js */
import Swiper from 'swiper/bundle';

document.addEventListener('DOMContentLoaded', () => {
    const swiperContainer = document.querySelector('.swiper-hero-banners');

    if (!swiperContainer) return;

    const slideElements = swiperContainer.querySelectorAll('.swiper-slide');
    const slideCount = slideElements.length;

    if (slideCount === 0) return;

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
});