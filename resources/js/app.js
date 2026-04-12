import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
import './bootstrap';

// Importa os scripts de interatividade do Gov.br
import '@govbr-ds/core/dist/core.min.js';

// Importa a lógica separada da Navbar
import './navbar';
import './widgets';

/**
 * ==========================================================================
 * PORTAL PREFEITURA MUNICIPAL DE ASSAÍ — app.js
 * JavaScript da área pública do portal (Global e Componentes Não-Navbar)
 *
 * Dependências externas (carregadas via CDN no layout):
 * - Swiper JS   → https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js
 * - VLibras     → https://vlibras.gov.br/app/vlibras-plugin.js
 * ==========================================================================
 */

document.addEventListener('DOMContentLoaded', function () {

    const safeStorageGet = function (key) {
        try {
            return window.localStorage.getItem(key);
        } catch (e) {
            return null;
        }
    };

    const safeStorageSet = function (key, value) {
        try {
            window.localStorage.setItem(key, value);
            return true;
        } catch (e) {
            return false;
        }
    };

    const shouldSkipLazyForImage = function (imgElement) {
        if (!(imgElement instanceof HTMLImageElement)) return true;
        if (imgElement.hasAttribute('loading')) return true;
        if (imgElement.dataset.noLazy === 'true') return true;
        if ((imgElement.getAttribute('fetchpriority') || '').toLowerCase() === 'high') return true;
        if (imgElement.closest('#site-header, #hero-video-loader, #hero-mobile-loader')) return true;
        return false;
    };

    const applyGlobalLazyLoading = function (rootNode) {
        if (!rootNode) return;

        const candidates = [];
        if (rootNode instanceof Element && (rootNode.tagName === 'IMG' || rootNode.tagName === 'IFRAME')) {
            candidates.push(rootNode);
        }

        if (rootNode.querySelectorAll) {
            rootNode.querySelectorAll('img, iframe').forEach(function (mediaEl) {
                candidates.push(mediaEl);
            });
        }

        candidates.forEach(function (mediaEl) {
            if (mediaEl instanceof HTMLImageElement) {
                if (shouldSkipLazyForImage(mediaEl)) return;
                mediaEl.loading = 'lazy';
                if (!mediaEl.hasAttribute('decoding')) {
                    mediaEl.decoding = 'async';
                }
                return;
            }

            if (mediaEl instanceof HTMLIFrameElement && !mediaEl.hasAttribute('loading')) {
                mediaEl.loading = 'lazy';
            }
        });
    };

    applyGlobalLazyLoading(document);

    const lazyMediaObserver = new MutationObserver(function (mutationList) {
        mutationList.forEach(function (mutation) {
            mutation.addedNodes.forEach(function (addedNode) {
                if (addedNode instanceof Element) {
                    applyGlobalLazyLoading(addedNode);
                }
            });
        });
    });
    lazyMediaObserver.observe(document.body, { childList: true, subtree: true });

    const globalSiteHeader = document.getElementById('site-header');
    const enforceGlobalTopReset = function () {
        document.documentElement.style.marginTop = '0px';
        document.documentElement.style.paddingTop = '0px';
        document.body.style.marginTop = '0px';
        document.body.style.paddingTop = '0px';

        if (globalSiteHeader) {
            globalSiteHeader.style.top = '0px';
            globalSiteHeader.style.marginTop = '0px';
            globalSiteHeader.style.paddingTop = '0px';
        }
    };

    enforceGlobalTopReset();

    const bodyTopResetObserver = new MutationObserver(function () {
        enforceGlobalTopReset();
    });
    bodyTopResetObserver.observe(document.body, { attributes: true, attributeFilter: ['style', 'class'] });

    const htmlTopResetObserver = new MutationObserver(function () {
        enforceGlobalTopReset();
    });
    htmlTopResetObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['style', 'class'] });

    /* ==========================================================================
       HERO VIDEO LAZY LOAD (Home)
       Só revela a home após o vídeo estar pronto e tocando
       ========================================================================== */
    var lazyVideo = document.getElementById('hero-video-lazy');
    var homeMain = document.getElementById('home-main');
    var heroLoader = document.getElementById('hero-video-loader');
    var mobileHeroLoader = document.getElementById('hero-mobile-loader');

    if (homeMain && (heroLoader || mobileHeroLoader || lazyVideo)) {
        var siteHeader = document.getElementById('site-header');
        var viewportQuery = window.matchMedia('(max-width: 1023px)');
        var isMobileViewport = viewportQuery.matches;
        var viewportReloadKey = 'portal_assai_viewport_reload_at';
        var hasInitializedVideo = false;
        var hasRevealedHome = false;

        var reloadOnViewportModeChange = function () {
            var now = Date.now();
            var lastReloadAt = 0;

            try {
                lastReloadAt = Number(window.sessionStorage.getItem(viewportReloadKey) || '0');
                if (now - lastReloadAt < 1500) return;
                window.sessionStorage.setItem(viewportReloadKey, String(now));
            } catch (e) {
                // Ignora falhas de storage e segue com reload.
            }

            window.location.reload();
        };

        if (viewportQuery.addEventListener) {
            viewportQuery.addEventListener('change', reloadOnViewportModeChange);
        } else if (viewportQuery.addListener) {
            viewportQuery.addListener(reloadOnViewportModeChange);
        }

        var enforceHomeTopReset = function () {
            document.documentElement.style.marginTop = '0px';
            document.documentElement.style.paddingTop = '0px';
            document.body.style.marginTop = '0px';
            document.body.style.paddingTop = '0px';

            if (siteHeader) {
                siteHeader.style.top = '0px';
                siteHeader.style.marginTop = '0px';
                siteHeader.style.paddingTop = '0px';
            }

            if (homeMain) {
                homeMain.style.marginTop = '0px';
                homeMain.style.paddingTop = '0px';
            }
        };

        enforceHomeTopReset();

        if (isMobileViewport) {
            var hasRevealedMobileHome = false;
            var portalConfig = document.getElementById('portal-config');
            var mobileLogoBlackSrc = portalConfig && portalConfig.dataset ? (portalConfig.dataset.logoBlack || '') : '';
            var mobileNavLogo = document.getElementById('nav-logo-img');
            var hardHideMobileLoader = function () {
                if (!mobileHeroLoader) return;
                mobileHeroLoader.classList.add('hidden');
                mobileHeroLoader.style.display = 'none';
                mobileHeroLoader.style.opacity = '0';
                mobileHeroLoader.style.pointerEvents = 'none';
                mobileHeroLoader.setAttribute('aria-hidden', 'true');
            };

            var revealMobileHome = function () {
                if (hasRevealedMobileHome) return;
                hasRevealedMobileHome = true;

                // Mantém consistência visual: no mobile a home usa navbar sólida com logo preta.
                if (siteHeader) {
                    siteHeader.classList.remove('bg-transparent', 'text-white', 'border-transparent');
                    siteHeader.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
                }

                if (mobileNavLogo && mobileLogoBlackSrc) {
                    if ((mobileNavLogo.getAttribute('src') || '') !== mobileLogoBlackSrc) {
                        mobileNavLogo.setAttribute('src', mobileLogoBlackSrc);
                    }
                    mobileNavLogo.style.transform = 'translateX(6px)';
                    mobileNavLogo.style.opacity = '1';
                }

                if (homeMain) {
                    homeMain.classList.remove('opacity-0');
                    homeMain.setAttribute('aria-busy', 'false');
                }

                if (siteHeader) {
                    siteHeader.classList.remove('opacity-0', 'pointer-events-none');
                }

                if (mobileHeroLoader) {
                    mobileHeroLoader.classList.add('opacity-0', 'pointer-events-none');
                    setTimeout(function () {
                        hardHideMobileLoader();
                    }, 520);
                }
            };

            if (homeMain) {
                homeMain.setAttribute('aria-busy', 'true');
            }

            if (homeMain) {
                homeMain.classList.remove('opacity-0');
            }

            if (siteHeader) {
                siteHeader.classList.remove('opacity-0', 'pointer-events-none');
            }

            if (heroLoader) {
                heroLoader.classList.add('hidden');
            }

            if (document.readyState === 'complete') {
                requestAnimationFrame(revealMobileHome);
            } else {
                window.addEventListener('load', revealMobileHome, { once: true });
            }

            window.addEventListener('pageshow', revealMobileHome, { once: true });

            setTimeout(revealMobileHome, 2200);
            setTimeout(hardHideMobileLoader, 3200);

            return;
        }

        if (homeMain) {
            homeMain.setAttribute('aria-busy', 'true');
        }

        if (siteHeader) {
            siteHeader.classList.add('opacity-0', 'pointer-events-none');
        }

        // Garantir que o loader desktop fique visível
        if (heroLoader) {
            heroLoader.classList.remove('hidden');
        }

        var bodyStyleObserver = new MutationObserver(function () {
            enforceHomeTopReset();
        });
        bodyStyleObserver.observe(document.body, { attributes: true, attributeFilter: ['style', 'class'] });

        var htmlStyleObserver = new MutationObserver(function () {
            enforceHomeTopReset();
        });
        htmlStyleObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['style', 'class'] });

        var desktopLoaderStartAt = Date.now();
        var desktopLoaderMinDurationMs = 1400;

        var revealHome = function () {
            if (hasRevealedHome) return;
            var elapsed = Date.now() - desktopLoaderStartAt;
            if (elapsed < desktopLoaderMinDurationMs) {
                setTimeout(revealHome, desktopLoaderMinDurationMs - elapsed);
                return;
            }
            hasRevealedHome = true;

            if (lazyVideo) {
                lazyVideo.classList.remove('opacity-0');
                lazyVideo.classList.add('opacity-80');
            }

            if (homeMain) {
                homeMain.classList.remove('opacity-0');
                homeMain.setAttribute('aria-busy', 'false');
            }

            if (heroLoader) {
                heroLoader.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(function () {
                    heroLoader.classList.add('hidden');
                }, 520);
            }

            if (siteHeader) {
                siteHeader.classList.remove('opacity-0', 'pointer-events-none');
            }

            enforceHomeTopReset();
        };

        var hydrateSources = function () {
            if (!lazyVideo) return;
            var sources = lazyVideo.querySelectorAll('source');
            sources.forEach(function (videoSource) {
                if (videoSource.dataset.src && !videoSource.src) {
                    videoSource.src = videoSource.dataset.src;
                }
            });
        };

        var startVideoLazy = function () {
            if (hasInitializedVideo) return;
            hasInitializedVideo = true;

            if (!lazyVideo) {
                revealHome();
                return;
            }

            hydrateSources();

            var tryPlayAndReveal = function () {
                lazyVideo.play()
                    .then(function () {
                        // A liberação principal ocorre no evento "playing".
                    })
                    .catch(function () {
                        revealHome();
                    });
            };

            lazyVideo.addEventListener('playing', revealHome, { once: true });
            lazyVideo.addEventListener('error', function () {
                revealHome();
            }, { once: true });

            if (lazyVideo.readyState >= HTMLMediaElement.HAVE_CURRENT_DATA) {
                tryPlayAndReveal();
            } else {
                lazyVideo.addEventListener('canplay', tryPlayAndReveal, { once: true });
            }

            lazyVideo.load();

            // Fail-safe para nunca travar a página em conexões ruins
            setTimeout(function () {
                revealHome();
            }, 9000);
        };

        if (lazyVideo && 'IntersectionObserver' in window) {
            var lazyVideoObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        startVideoLazy();
                        lazyVideoObserver.unobserve(entry.target);
                    }
                });
            }, { root: null, rootMargin: '120px 0px', threshold: 0.01 });

            lazyVideoObserver.observe(lazyVideo);
            
            // Fallback: se o vídeo já está em viewport no load, inicia imediatamente
            setTimeout(function () {
                if (!hasInitializedVideo) {
                    startVideoLazy();
                }
            }, 100);
        } else {
            startVideoLazy();
        }

        // Trigger alternativo: quando a seção desktop fica visível (para "visualizar como computador")
        var heroOficial = document.getElementById('hero-oficial');
        if (heroOficial && 'IntersectionObserver' in window) {
            var heroSectionObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting && !hasInitializedVideo) {
                        startVideoLazy();
                    }
                });
            }, { root: null, threshold: 0.1 });

            heroSectionObserver.observe(heroOficial);
        }
    }



    /* ==========================================================================
       INICIALIZAÇÃO: CARROSSEL DE ALERTAS DO CABEÇALHO
       Rotação vertical automática dos alertas da barra superior
       ========================================================================== */
    var swiperAlertasEl = document.querySelector('.swiper-alertas');
    if (swiperAlertasEl && typeof Swiper !== 'undefined') {
        var isMobileAlerts = window.matchMedia('(max-width: 640px)').matches;
        new Swiper('.swiper-alertas', {
            direction: isMobileAlerts ? 'horizontal' : 'vertical',
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });
    }

    /* ==========================================================================
       BANNER DE COOKIES (LGPD)
       Exibe o banner se o utilizador ainda não aceitou; persiste a aceitação
       ========================================================================== */
    var cookieBanner = document.getElementById('cookie-banner');
    var acceptBtn = document.getElementById('accept-cookies');
    if (cookieBanner && acceptBtn) {
        if (!safeStorageGet('cookiesAceitos_Assai')) {
            cookieBanner.classList.remove('hidden');
        }
        acceptBtn.addEventListener('click', function () {
            safeStorageSet('cookiesAceitos_Assai', 'true');
            cookieBanner.classList.add('hidden');
        });
    }

    /* ==========================================================================
       BUSCA DA PÁGINA INICIAL: BOTÃO LIMPAR (CLEAR)
       Exibe/oculta o botão "×" conforme o utilizador digita
       ========================================================================== */
    var inputBusca = document.getElementById('input-busca');
    var btnLimpar = document.getElementById('btn-limpar-busca');
    var dropdownAC = document.getElementById('autocomplete-results');
    var chipsIA = document.getElementById('ia-suggestions');

    if (inputBusca && btnLimpar) {
        inputBusca.addEventListener('input', function () {
            btnLimpar.classList.toggle('hidden', this.value.length === 0);
        });

        btnLimpar.addEventListener('click', function () {
            inputBusca.value = '';
            inputBusca.focus();
            btnLimpar.classList.add('hidden');
            if (chipsIA) chipsIA.classList.remove('hidden');
            hideDropdown();
        });
    }

    /* ==========================================================================
       BUSCA DA PÁGINA INICIAL: AUTOCOMPLETE
       ========================================================================== */
    var TYPE_COLORS = {
        'Notícia': 'bg-blue-50 text-blue-700',
        'Serviço': 'bg-emerald-50 text-emerald-700',
        'Programa': 'bg-purple-50 text-purple-700',
        'Secretaria': 'bg-slate-100 text-slate-600',
    };

    function showDropdown() {
        if(!dropdownAC) return;
        dropdownAC.classList.remove('hidden');
        requestAnimationFrame(function () {
            dropdownAC.classList.remove('opacity-0');
        });
        if (chipsIA) chipsIA.classList.add('hidden');
    }

    function hideDropdown() {
        if(!dropdownAC) return;
        dropdownAC.classList.add('opacity-0');
        setTimeout(function () {
            dropdownAC.classList.add('hidden');
        }, 200);
        if (chipsIA && inputBusca && inputBusca.value.trim().length < 2) chipsIA.classList.remove('hidden');
    }

    var debounceTimer;
    var autocompleteController = null;

    if (inputBusca) {
        inputBusca.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            var termo = this.value.trim();

            if (chipsIA) {
                chipsIA.classList.toggle('hidden', termo.length >= 2);
            }

            if (termo.length < 2) {
                if (autocompleteController) {
                    autocompleteController.abort();
                    autocompleteController = null;
                }
                hideDropdown();
                return;
            }

            var formElement = document.getElementById('form-busca');
            var autocompleteUrl = formElement ? formElement.dataset.autocompleteUrl : null;

            if (!autocompleteUrl) return;

            debounceTimer = setTimeout(function () {
                if (autocompleteController) {
                    autocompleteController.abort();
                }

                autocompleteController = new AbortController();

                fetch(autocompleteUrl + '?q=' + encodeURIComponent(termo), { signal: autocompleteController.signal })
                    .then(function (res) {
                        if (!res.ok) throw new Error('Falha no autocomplete');
                        return res.json();
                    })
                    .then(function (data) {
                        if (data.length === 0) {
                            dropdownAC.innerHTML =
                                '<p class="px-5 py-4 text-sm text-slate-400 text-center">' +
                                'Nenhum resultado rápido encontrado.' +
                                '<span class="block text-xs mt-0.5">Pressione ' +
                                '<kbd class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-500 font-mono">Enter</kbd>' +
                                ' para busca avançada.</span></p>';
                        } else {
                            var items = data.map(function (item) {
                                var badgeClass = TYPE_COLORS[item.tipo] || 'bg-gray-100 text-gray-600';
                                return '<li><a href="' + item.url + '" ' +
                                    'class="flex items-center justify-between gap-3 px-5 py-3 hover:bg-blue-50 transition-colors group">' +
                                    '<span class="text-sm font-medium text-slate-700 group-hover:text-blue-700 line-clamp-1">' + item.titulo + '</span>' +
                                    '<span class="shrink-0 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide rounded-full ' + badgeClass + '">' + item.tipo + '</span>' +
                                    '</a></li>';
                            }).join('');
                            dropdownAC.innerHTML = '<ul class="divide-y divide-slate-50">' + items + '</ul>';
                        }
                        showDropdown();
                    })
                    .catch(function (err) {
                        if (err && err.name === 'AbortError') return;
                        hideDropdown();
                    });
            }, 300);
        });
    }

    document.addEventListener('click', function (e) {
        var form = document.getElementById('form-busca');
        if (form && !form.contains(e.target)) {
            hideDropdown();
        }
    });

    var formBusca = document.getElementById('form-busca');
    if (formBusca) {
        formBusca.addEventListener('submit', function () {
            hideDropdown();
        });
    }

    /* ==========================================================================
       FILTRO DE SECRETARIAS (Pesquisa em tempo real)
       ========================================================================== */
    var inputBuscaSecretaria = document.getElementById('busca-secretaria');
    if (inputBuscaSecretaria) {
        inputBuscaSecretaria.addEventListener('keyup', function () {
            var termo = this.value.toLowerCase().trim();
            document.querySelectorAll('#grid-secretarias > div').forEach(function (card) {
                var nome = card.querySelector('h2') ? card.querySelector('h2').textContent.toLowerCase() : '';
                card.style.display = nome.includes(termo) ? '' : 'none';
            });
        });
    }

    /* ==========================================================================
       INICIALIZAÇÃO DAS ABAS DA PÁGINA DE RESULTADOS DE BUSCA
       ========================================================================== */
    if (document.querySelector('.tab-btn')) {
        var tabFilterNav = document.getElementById('tab-filter-nav');
        var initialTab = tabFilterNav ? (tabFilterNav.getAttribute('data-active-tab') || 'all') : 'all';
        if (typeof window.filterResults === 'function') {
            window.filterResults(initialTab, false);
        }
    }

    /* ==========================================================================
       LÓGICA DO LOADER: PÁGINAS INTERNAS
       Revela o conteúdo apenas após a estabilização do layout (evita "pulo" do menu)
       ========================================================================== */
    const internalLoader = document.getElementById('internal-page-loader');
    const mainWrapper = document.getElementById('main-content-wrapper');

    if (internalLoader && mainWrapper) {
        const revealInternalPage = () => {
            // Delay tático para garantir que o syncHeaderHeightVar no navbar.js já estabilizou o DOM
            // Aumentado para 400ms para cobertura total de renderização e scripts
            setTimeout(() => {
                internalLoader.classList.add('opacity-0', 'pointer-events-none');
                mainWrapper.classList.remove('opacity-0');
                
                setTimeout(() => {
                    if (internalLoader.parentNode) {
                        internalLoader.remove();
                    }
                }, 600);
            }, 400);
        };

        if (document.readyState === 'complete') {
            revealInternalPage();
        } else {
            window.addEventListener('load', revealInternalPage, { once: true });
        }

        // Fail-safe de 3s (nunca deixa o utilizador preso em tela de loading)
        setTimeout(revealInternalPage, 3000);
    }
});

/* ==========================================================================
   FUNÇÕES GLOBAIS (Atreladas ao Window)
   ========================================================================== */

window.preencherBusca = function (termo) {
    var input = document.getElementById('input-busca');
    var form = document.getElementById('form-busca');
    var btnLimpar = document.getElementById('btn-limpar-busca');
    
    if (input && form) {
        input.value = termo;
        input.focus();
        if (btnLimpar) btnLimpar.classList.remove('hidden');
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        } else {
            form.submit();
        }
    }
};

window.carregarCalendario = function(url) {
    var container = document.getElementById('calendario-container');
    if (!container) return;

    container.style.opacity = '0.5';
    container.style.pointerEvents = 'none';

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function (res) {
            if (!res.ok) throw new Error('Erro ao carregar calendário');
            return res.text();
        })
        .then(function (html) {
            container.innerHTML = html;
        })
        .catch(function (err) {
            console.error(err);
        })
        .finally(function () {
            container.style.opacity = '1';
            container.style.pointerEvents = '';
        });
};

/* ==========================================================================
   BOTÃO BACK TO TOP (Regresso ao topo suave)
   ========================================================================== */
(function () {
    var btn = document.getElementById('btn-back-to-top');
    if (!btn) return;

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            btn.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
            btn.classList.add('opacity-100', 'translate-y-0');
        } else {
            btn.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
            btn.classList.remove('opacity-100', 'translate-y-0');
        }
    }, { passive: true });
}());