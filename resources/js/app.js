import './bootstrap';

// Importa os scripts de interatividade do Gov.br
import '@govbr-ds/core/dist/core.min.js';

/**
 * ==========================================================================
 * PORTAL PREFEITURA MUNICIPAL DE ASSAÍ — portal.js
 * JavaScript da área pública do portal
 *
 * Dependências externas (carregadas via CDN no layout):
 *   - Swiper JS   → https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js
 *   - VLibras     → https://vlibras.gov.br/app/vlibras-plugin.js
 * ==========================================================================
 */


/* NOTA: o IIFE que restaura fontSize e contrast-mode ANTES da 1ª pintura
   está embutido inline em <head> no layouts/app.blade.php.
   Não duplicar aqui — um script externo carrega tarde demais para evitar flash. */

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
	   ACESSIBILIDADE: CONTROLO DE TAMANHO DE FONTE
	   Botões de aumentar/diminuir fonte com limites mín/máx e persistência
	   ========================================================================== */
	var htmlEl = document.documentElement;
	var MIN_SIZE = 14, MAX_SIZE = 20, STEP = 2;

	function getCurrentFontSize() {
		var stored = localStorage.getItem('a11y_fontSize');
		return stored ? parseInt(stored) : 16;
	}

	var btnIncrease = document.getElementById('btn-increase-font');
	if (btnIncrease) {
		btnIncrease.addEventListener('click', function () {
			var next = Math.min(getCurrentFontSize() + STEP, MAX_SIZE);
			htmlEl.style.fontSize = next + 'px';
			localStorage.setItem('a11y_fontSize', next);
		});
	}

	var btnDecrease = document.getElementById('btn-decrease-font');
	if (btnDecrease) {
		btnDecrease.addEventListener('click', function () {
			var next = Math.max(getCurrentFontSize() - STEP, MIN_SIZE);
			htmlEl.style.fontSize = next + 'px';
			localStorage.setItem('a11y_fontSize', next);
		});
	}


	/* ==========================================================================
	   ACESSIBILIDADE: MODO DE ALTO CONTRASTE
	   Toggle da classe `contrast-mode` com persistência no localStorage
	   ========================================================================== */
	var btnContrast = document.getElementById('btn-contrast');
	if (btnContrast) {
		btnContrast.setAttribute(
			'aria-pressed',
			htmlEl.classList.contains('contrast-mode') ? 'true' : 'false'
		);
		btnContrast.addEventListener('click', function () {
			htmlEl.classList.toggle('contrast-mode');
			var active = htmlEl.classList.contains('contrast-mode');
			localStorage.setItem('a11y_contrast', active ? '1' : '0');
			this.setAttribute('aria-pressed', active ? 'true' : 'false');
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
	   MENU MOBILE: ACORDEÃO "A CIDADE"
	   Expande/colapsa o submenu no cabeçalho mobile
	   ========================================================================== */
	var btnCidade = document.getElementById('btn-cidade-mobile');
	var submenuCidade = document.getElementById('submenu-cidade-mobile');
	var iconCidade = document.getElementById('icon-cidade-mobile');
	if (btnCidade && submenuCidade && iconCidade) {
		btnCidade.addEventListener('click', function () {
			submenuCidade.classList.toggle('hidden');
			iconCidade.classList.toggle('rotate-180');
			var expanded = !submenuCidade.classList.contains('hidden');
			btnCidade.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		});
	}

	var mobileMenuButton = document.getElementById('mobile-menu-button');
	var mobileMenu = document.getElementById('mobile-menu');
	if (mobileMenuButton && mobileMenu) {
		mobileMenuButton.addEventListener('click', function () {
			mobileMenu.classList.toggle('hidden');
			var expanded = !mobileMenu.classList.contains('hidden');
			mobileMenuButton.setAttribute('aria-expanded', expanded ? 'true' : 'false');
			mobileMenuButton.setAttribute('aria-label', expanded ? 'Fechar menu principal' : 'Abrir menu principal');
		});
	}

	var desktopCidadeButton = document.getElementById('btn-cidade-desktop');
	var desktopCidadeMenu = document.getElementById('submenu-cidade-desktop');
	if (desktopCidadeButton && desktopCidadeMenu) {
		desktopCidadeButton.addEventListener('focus', function () {
			desktopCidadeButton.setAttribute('aria-expanded', 'true');
		});
		desktopCidadeButton.addEventListener('blur', function () {
			setTimeout(function () {
				if (!desktopCidadeMenu.matches(':hover') && !desktopCidadeMenu.contains(document.activeElement)) {
					desktopCidadeButton.setAttribute('aria-expanded', 'false');
				}
			}, 50);
		});
		desktopCidadeButton.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				desktopCidadeButton.setAttribute('aria-expanded', 'false');
				desktopCidadeButton.blur();
			}
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

function carregarCalendario(url) {
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

function filterResults(type) {
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
		filterResults('all');
	}
});

document.addEventListener('DOMContentLoaded', function () {
	const header = document.getElementById('site-header');
	const topBar = document.getElementById('top-bar');
	const navInner = document.querySelector('.nav-inner');
	const logoBranca = document.getElementById('logo-branca');
	const logoPreta = document.getElementById('logo-preta');
	const navLinks = document.querySelectorAll('.nav-link');
	const navSpecial = document.querySelector('.nav-link-special');
	const mobileBtn = document.getElementById('hamburger-icon');

	if (!header) return;

	const isHome = document.getElementById('home-hero') !== null;

	function updateHeaderState() {
		if (!isHome) {
			// Em páginas internas: Fundo branco, MAS NÃO esconde a Top Bar
			applySolidState(false);
			return;
		}

		if (window.scrollY > 50) {
			applySolidState(true);
		} else {
			applyTransparentState();
		}
	}

	function applySolidState(hideTopBar = true) {
		header.classList.remove('bg-transparent', 'text-white');
		header.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'text-slate-700');

		if (topBar) {
			if (hideTopBar) {
				topBar.classList.add('h-0', 'opacity-0', 'overflow-hidden');
				topBar.classList.remove('py-2');
			} else {
				topBar.classList.remove('h-0', 'opacity-0', 'overflow-hidden');
				topBar.classList.add('py-2');
			}
		}

		if (navInner) navInner.classList.replace('py-4', 'py-2');

		if (logoBranca) logoBranca.classList.add('opacity-0');
		if (logoPreta) logoPreta.classList.remove('opacity-0');

		navLinks.forEach(link => link.classList.replace('hover:text-yellow-400', 'hover:text-blue-600'));
		if (mobileBtn) mobileBtn.classList.replace('text-white', 'text-blue-900');

		if (navSpecial) {
			navSpecial.classList.replace('text-green-300', 'text-emerald-600');
			navSpecial.classList.replace('border-white/20', 'border-emerald-200');
			navSpecial.classList.replace('bg-white/10', 'bg-emerald-50');
		}
	}

	function applyTransparentState() {
		header.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'text-slate-700');
		header.classList.add('bg-transparent', 'text-white');

		if (topBar) {
			topBar.classList.remove('h-0', 'opacity-0', 'overflow-hidden');
			topBar.classList.add('py-2');
		}

		if (navInner) navInner.classList.replace('py-2', 'py-4');

		if (logoBranca) logoBranca.classList.remove('opacity-0');
		if (logoPreta) logoPreta.classList.add('opacity-0');

		navLinks.forEach(link => link.classList.replace('hover:text-blue-600', 'hover:text-yellow-400'));
		if (mobileBtn) mobileBtn.classList.replace('text-blue-900', 'text-white');

		if (navSpecial) {
			navSpecial.classList.replace('text-emerald-600', 'text-green-300');
			navSpecial.classList.replace('border-emerald-200', 'border-white/20');
			navSpecial.classList.replace('bg-emerald-50', 'bg-white/10');
		}
	}

	// 1. Primeiro aplica as regras do estado (o que faz o menu encolher)
	window.addEventListener('scroll', updateHeaderState, { passive: true });
	updateHeaderState();

	// 2. DEPOIS liga o radar de altura para evitar a linha branca
	if (!isHome && window.ResizeObserver) {
		new ResizeObserver(() => {
			document.body.style.paddingTop = header.offsetHeight + 'px';
		}).observe(header);
	}
});