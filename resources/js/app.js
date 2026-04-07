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

    /* ==========================================================================
       INICIALIZAÇÃO: CARROSSEL DE BANNERS DA PÁGINA INICIAL
       Desactiva navegação por arraste e activa rotação automática a cada 5s
       Dependência: Swiper JS (CDN)
       ========================================================================== */
    var swiperBannersEl = document.querySelector('.swiper-banners');
    if (swiperBannersEl && typeof Swiper !== 'undefined') {
        new Swiper('.swiper-banners', {
            loop: true,
            allowTouchMove: false,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.banner-swiper-next',
                prevEl: '.banner-swiper-prev',
            },
        });
    }

    /* ==========================================================================
       INICIALIZAÇÃO: CARROSSEL DE ALERTAS DO CABEÇALHO
       Rotação vertical automática dos alertas da barra superior
       Dependência: Swiper JS (CDN)
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
        if (!localStorage.getItem('cookiesAceitos_Assai')) {
            cookieBanner.classList.remove('hidden');
        }
        acceptBtn.addEventListener('click', function () {
            localStorage.setItem('cookiesAceitos_Assai', 'true');
            cookieBanner.classList.add('hidden');
        });
    }

    /* ==========================================================================
       BUSCA DA PÁGINA INICIAL: BOTÃO LIMPAR (CLEAR)
       Exibe/oculta o botão "×" conforme o utilizador digita na barra de busca
       ========================================================================== */
    var inputBusca = document.getElementById('input-busca');
    var btnLimpar = document.getElementById('btn-limpar-busca');
    var dropdownAC = document.getElementById('autocomplete-results');
    var chipsIA = document.getElementById('ia-suggestions');

    if (!inputBusca || !btnLimpar) return;

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
        dropdownAC.classList.remove('hidden');
        requestAnimationFrame(function () {
            dropdownAC.classList.remove('opacity-0');
        });
        if (chipsIA) chipsIA.classList.add('hidden');
    }

    function hideDropdown() {
        dropdownAC.classList.add('opacity-0');
        setTimeout(function () {
            dropdownAC.classList.add('hidden');
        }, 200);
        if (chipsIA && inputBusca.value.trim().length < 2) chipsIA.classList.remove('hidden');
    }

    var debounceTimer;
    var autocompleteController = null;

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

        var autocompleteUrl = document.getElementById('form-busca')
            ? document.getElementById('form-busca').dataset.autocompleteUrl
            : null;

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

});

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
}

document.addEventListener('DOMContentLoaded', function () {
    var inputBuscaSecretaria = document.getElementById('busca-secretaria');
    if (!inputBuscaSecretaria) return;

    inputBuscaSecretaria.addEventListener('keyup', function () {
        var termo = this.value.toLowerCase().trim();
        document.querySelectorAll('#grid-secretarias > div').forEach(function (card) {
            var nome = card.querySelector('h2') ? card.querySelector('h2').textContent.toLowerCase() : '';
            card.style.display = nome.includes(termo) ? '' : 'none';
        });
    });
});

// Botão Back To Top
(function () {
    var btn = document.getElementById('btn-back-to-top');
    if (!btn) return;

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

window.filterResults = function(type) {
    var sections = document.querySelectorAll('.result-section');
    var buttons = document.querySelectorAll('.tab-btn');

    buttons.forEach(function (btn) {
        btn.classList.remove('active', 'bg-blue-900', 'text-white');
        btn.classList.add('text-gray-500', 'hover:bg-gray-50');
        btn.setAttribute('aria-selected', 'false');
        if (btn.getAttribute('data-target') === type) {
            btn.classList.add('active');
            btn.classList.remove('text-gray-500', 'hover:bg-gray-50');
            btn.classList.add('bg-blue-900', 'text-white');
            btn.setAttribute('aria-selected', 'true');
        }
    });

    sections.forEach(function (section) {
        if (type === 'all') {
            section.classList.remove('hidden');
            return;
        }
        section.classList.toggle('hidden', section.id !== 'sec-' + type);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.tab-btn')) {
        window.filterResults('all');
    }
});