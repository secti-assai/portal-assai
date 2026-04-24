/**
 * ==========================================================================
 * PORTAL PREFEITURA MUNICIPAL DE ASSAÍ — widgets.js
 * Widgets Alpine.js: Clima e Plantão do Dia
 *
 * Registra os componentes no evento 'alpine:init', compatível com
 * Alpine.js carregado via CDN (defer) ou via npm.
 * ==========================================================================
 */

const registerWidgets = () => {
    const resolvePortalEndpoint = (dataAttrName, fallbackPath) => {
        const raw = document.querySelector('[data-' + dataAttrName + ']')?.dataset?.[dataAttrName] || '';

        if (!raw) {
            return fallbackPath;
        }

        try {
            const parsed = new URL(raw, window.location.origin);

            if (parsed.host === window.location.host) {
                return parsed.pathname + parsed.search + parsed.hash;
            }

            return parsed.toString();
        } catch (e) {
            return fallbackPath;
        }
    };

    // ---- WIDGET DO CLIMA ----
    Alpine.data('weatherWidget', () => ({
        temperature: null,
        apparentTemperature: null,
        humidity: null,
        windSpeed: null,
        precipitation: null,
        weatherCode: null,
        loading: true,
        error: false,

        formatNumber(value) {
            if (value === null || value === undefined || Number.isNaN(value)) return '--';
            return Math.round(value);
        },

        get weatherLabel() {
            const code = Number(this.weatherCode);
            if (code === 0) return 'Céu limpo';
            if ([1, 2].includes(code)) return 'Poucas nuvens';
            if (code === 3) return 'Nublado';
            if ([45, 48].includes(code)) return 'Nevoeiro';
            if ([51, 53, 55].includes(code)) return 'Garoa';
            if ([56, 57].includes(code)) return 'Garoa gelada';
            if ([61, 63, 65].includes(code)) return 'Chuva';
            if ([66, 67].includes(code)) return 'Chuva gelada';
            if ([71, 73, 75, 77, 85, 86].includes(code)) return 'Neve';
            if ([80, 81, 82].includes(code)) return 'Pancadas';
            if ([95, 96, 99].includes(code)) return 'Trovoadas';
            return 'Tempo instável';
        },

        get weatherIconClass() {
            const code = Number(this.weatherCode);
            if (code === 0) return 'fas fa-sun';
            if ([1, 2].includes(code)) return 'fas fa-cloud-sun';
            if (code === 3) return 'fas fa-cloud';
            if ([45, 48].includes(code)) return 'fas fa-smog';
            if ([51, 53, 55, 56, 57].includes(code)) return 'fas fa-cloud-rain';
            if ([61, 63, 65, 66, 67, 80, 81, 82].includes(code)) return 'fas fa-cloud-showers-heavy';
            if ([71, 73, 75, 77, 85, 86].includes(code)) return 'fas fa-snowflake';
            if ([95, 96, 99].includes(code)) return 'fas fa-bolt';
            return 'fas fa-cloud';
        },

        async init() {
            try {
                const weatherUrl = resolvePortalEndpoint('weatherUrl', '/api/clima-atual');

                const response = await fetch(weatherUrl, {
                    credentials: 'same-origin',
                    cache: 'no-store',
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('API Error');

                const data = await response.json();
                if (data?.error || !data?.current) throw new Error('API Payload Error');

                this.temperature = this.formatNumber(data.current.temperature_2m);
                this.apparentTemperature = this.formatNumber(data.current.apparent_temperature);
                this.humidity = this.formatNumber(data.current.relative_humidity_2m);
                this.windSpeed = this.formatNumber(data.current.wind_speed_10m);
                this.precipitation = this.formatNumber(data.current.precipitation);
                this.weatherCode = this.formatNumber(data.current.weather_code);
                this.error = false;
            } catch (err) {
                this.error = true;
            } finally {
                this.loading = false;
            }
        }
    }));

    // ---- WIDGET DO PLANTÃO ----
    Alpine.data('dutyWidget', () => ({
        loading: true,
        error: false,
        hasDuty: false,
        farmacia: null,
        posto: null,
        message: '',
        previewMode: false,
        rotationItems: [],
        activeDutyIndex: 0,
        rotationTimer: null,

        formatAddress(address) {
            if (!address) return '';
            const parts = String(address).split(',').map((part) => part.trim()).filter(Boolean);
            if (parts.length >= 2) return parts[0] + ', ' + parts[1];
            return parts[0] ?? '';
        },

        formatDutyText(item, fallbackType) {
            if (!item) return '';
            const name = String(item.title || item.type || fallbackType || 'Plantao').trim();
            const address = this.formatAddress(item.address || '');
            const phone = String(item.contact || '').trim();
            let output = name + ': ' + (address || 'Endereco indisponivel');
            if (phone) output += ' - ' + phone;
            return output;
        },

        buildRotationItems() {
            this.rotationItems = [];
            if (this.farmacia) {
                this.rotationItems.push({
                    kind: 'farmacia',
                    text: this.formatDutyText(this.farmacia, 'Farmacia')
                });
            }
            if (this.posto) {
                this.rotationItems.push({
                    kind: 'posto',
                    text: this.formatDutyText(this.posto, 'Posto de combustivel')
                });
            }
            this.activeDutyIndex = 0;
        },

        startRotation() {
            this.stopRotation();
            if (this.rotationItems.length > 1) {
                this.rotationTimer = setInterval(() => {
                    this.activeDutyIndex = (this.activeDutyIndex + 1) % this.rotationItems.length;
                }, 5000);
            }
        },

        stopRotation() {
            if (this.rotationTimer) {
                clearInterval(this.rotationTimer);
                this.rotationTimer = null;
            }
        },

        get dutySummary() {
            if (!this.rotationItems.length) return '';
            if (this.previewMode) {
                return this.rotationItems.map((item) => item.text).join(' | ');
            }
            return this.rotationItems[this.activeDutyIndex]?.text || '';
        },

        async init() {
            this.previewMode = (new URLSearchParams(window.location.search).get('preview_plantao') === '1');

            if (this.previewMode) {
                this.loading = false;
                this.error = false;
                this.message = '';
                this.farmacia = {
                    title: 'Farmacia Central',
                    address: 'Rua Brasil, 123',
                    contact: '(43) 99999-1111',
                    type: 'Farmacia'
                };
                this.posto = {
                    title: 'Auto Posto Assai',
                    address: 'Av. Rio de Janeiro, 456',
                    contact: '(43) 99999-2222',
                    type: 'Posto de combustivel'
                };
                this.hasDuty = true;
                this.buildRotationItems();
                this.stopRotation();
                return;
            }

            try {
                const dutyUrl = resolvePortalEndpoint('dutyUrl', '/api/plantao-hoje');

                const response = await fetch(dutyUrl, {
                    credentials: 'same-origin',
                    cache: 'no-store',
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) throw new Error('API Error');
                const data = await response.json();

                this.hasDuty = Boolean(data?.hasDuty);
                this.farmacia = data?.farmacia ?? null;
                this.posto = data?.posto ?? null;
                this.message = data?.message ?? '';
                this.buildRotationItems();
                this.startRotation();
                this.error = false;
            } catch (err) {
                this.stopRotation();
                this.error = true;
                this.hasDuty = false;
                this.message = 'Plantao indisponivel';
                this.rotationItems = [];
            } finally {
                this.loading = false;
            }
        }
    }));
};

// Garante o registro mesmo se ocorrer race condition com o CDN
if (window.Alpine) {
    registerWidgets();
} else {
    document.addEventListener('alpine:init', registerWidgets);
}
