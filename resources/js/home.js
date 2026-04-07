/* resources/js/home.js */
import Swiper from 'swiper/bundle';

document.addEventListener('DOMContentLoaded', () => {
    initHeroVideoRotator();

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

function initHeroVideoRotator() {
    const rotator = document.querySelector('[data-hero-videos]');

    if (!rotator) return;

    const videoSources = JSON.parse(rotator.getAttribute('data-hero-videos') || '[]').filter(Boolean);
    const videoLayers = Array.from(rotator.querySelectorAll('video'));

    if (videoSources.length === 0 || videoLayers.length < 2) return;

    const [firstLayer, secondLayer] = videoLayers;
    const hasSingleVideo = videoSources.length === 1;
    let activeLayer = firstLayer;
    let standbyLayer = secondLayer;
    let activeIndex = 0;
    let isTransitioning = false;

    const waitForReady = (videoElement) => {
        if (videoElement.readyState >= HTMLMediaElement.HAVE_CURRENT_DATA) {
            return Promise.resolve();
        }

        return new Promise((resolve, reject) => {
            const handleCanPlay = () => {
                cleanup();
                resolve();
            };

            const handleError = () => {
                cleanup();
                reject(new Error('Video failed to load'));
            };

            const cleanup = () => {
                videoElement.removeEventListener('canplay', handleCanPlay);
                videoElement.removeEventListener('loadeddata', handleCanPlay);
                videoElement.removeEventListener('error', handleError);
            };

            videoElement.addEventListener('canplay', handleCanPlay);
            videoElement.addEventListener('loadeddata', handleCanPlay);
            videoElement.addEventListener('error', handleError);
        });
    };

    const setVisibleLayer = (visibleLayer, hiddenLayer) => {
        visibleLayer.classList.remove('opacity-0');
        visibleLayer.classList.add('opacity-100');
        hiddenLayer.classList.remove('opacity-100');
        hiddenLayer.classList.add('opacity-0');
    };

    const loadVideo = async (videoElement, source) => {
        videoElement.pause();
        videoElement.currentTime = 0;
        videoElement.loop = false;
        videoElement.src = source;
        videoElement.load();
        await waitForReady(videoElement);
    };

    const playVideo = async (videoElement) => {
        await videoElement.play().catch(() => {});
    };

    const preloadStandby = async () => {
        const nextIndex = (activeIndex + 1) % videoSources.length;

        try {
            await loadVideo(standbyLayer, videoSources[nextIndex]);
        } catch (error) {
            console.error('Erro ao pré-carregar vídeo de fundo:', error);
        }
    };

    const playNext = async () => {
        if (isTransitioning || videoSources.length < 2) return;

        isTransitioning = true;
        const incomingLayer = standbyLayer;
        const outgoingLayer = activeLayer;
        const nextIndex = (activeIndex + 1) % videoSources.length;

        try {
            await waitForReady(incomingLayer);
            await playVideo(incomingLayer);
            setVisibleLayer(incomingLayer, outgoingLayer);

            activeLayer = incomingLayer;
            standbyLayer = outgoingLayer;
            activeIndex = nextIndex;
            activeLayer.onended = playNext;

            preloadStandby();
        } catch (error) {
            console.error('Erro ao alternar vídeo de fundo:', error);
        } finally {
            isTransitioning = false;
        }
    };

    const initialize = async () => {
        try {
            await loadVideo(activeLayer, videoSources[0]);
            activeLayer.loop = hasSingleVideo;
            await playVideo(activeLayer);
            if (!hasSingleVideo) {
                activeLayer.onended = playNext;
            }
        } catch (error) {
            console.error('Erro ao carregar vídeo inicial do hero:', error);
        }

        if (videoSources.length > 1) {
            preloadStandby();
        }
    };

    initialize();
}