/**
 * ==========================================================================
 * PORTAL PREFEITURA MUNICIPAL DE ASSAÍ — admin.js
 * JavaScript da área administrativa do portal (painel CMS)
 *
 * Dependências externas (carregadas via CDN no layout admin):
 *   - CKEditor 5 Classic → https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js
 *
 * Configuração dinâmica (injectada via <script> inline na view quando necessário):
 *   window.ADMIN_CONFIG = { editorUploadUrl: "..." }
 *   — Presente apenas em admin/noticias/create e admin/noticias/edit
 * ==========================================================================
 */


/* ==========================================================================
   UPLOAD ADAPTER (CKEDITOR 5)
   Permite enviar imagens do editor para o servidor via fetch.
   Só é usado quando window.ADMIN_CONFIG.editorUploadUrl está definido.
   ========================================================================= */
function PortalUploadAdapter(loader, uploadUrl, csrfToken) {
    this.loader    = loader;
    this.uploadUrl = uploadUrl;
    this.csrfToken = csrfToken;
}

PortalUploadAdapter.prototype.upload = function () {
    var self = this;
    return this.loader.file.then(function (file) {
        return new Promise(function (resolve, reject) {
            var data = new FormData();
            data.append('upload', file);
            fetch(self.uploadUrl, {
                method:  'POST',
                headers: { 'X-CSRF-TOKEN': self.csrfToken },
                body:    data,
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (res.url) {
                    resolve({ default: res.url });
                } else {
                    reject((res.error && res.error.message) ? res.error.message : 'Erro no upload de imagem.');
                }
            })
            .catch(reject);
        });
    });
};

PortalUploadAdapter.prototype.abort = function () {};


document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================================
       CKEDITOR 5: INICIALIZAÇÃO DO EDITOR DE TEXTO RICO
       — Modo simples: eventos (create/edit) — toolbar básica
       — Modo completo: notícias (create/edit) — toolbar + UploadImage
         (requer window.ADMIN_CONFIG.editorUploadUrl injectado pela view)
       ========================================================================= */
    var editorEl = document.getElementById('editor');
    if (editorEl && typeof ClassicEditor !== 'undefined') {

        var config = window.ADMIN_CONFIG && window.ADMIN_CONFIG.editorUploadUrl
            ? {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link',
                    'bulletedList', 'numberedList', 'blockQuote', '|',
                    'uploadImage', '|',
                    'undo', 'redo',
                ],
                extraPlugins: [
                    (function () {
                        var uploadUrl  = window.ADMIN_CONFIG.editorUploadUrl;
                        var csrfToken  = document.querySelector('meta[name="csrf-token"]')
                            ? document.querySelector('meta[name="csrf-token"]').content
                            : '';
                        return function (editor) {
                            editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                                return new PortalUploadAdapter(loader, uploadUrl, csrfToken);
                            };
                        };
                    })(),
                ],
              }
            : {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'],
              };

        ClassicEditor.create(editorEl, config)
            .catch(function (err) {
                console.error('CKEditor — erro ao inicializar:', err);
            });
    }


    /* ==========================================================================
       ADMIN — TOGGLE DE DESTAQUE (PROGRAMAS)
       Alterna o destaque de um programa na página inicial.
       Recarrega a página para reflectir a nova ordenação.
    Trata 422 (limite de 6 destaques atingido) exibindo a mensagem do servidor.
       ========================================================================= */
    document.querySelectorAll('.btn-toggle-destaque').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var self      = this;
            var url       = this.dataset.url;
            var csrfMeta  = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMeta || !url) return;

            self.disabled = true;

            fetch(url, {
                method:  'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta.content,
                    'Accept':       'application/json',
                },
            })
            .then(function (res) {
                if (res.status === 422) {
                    return res.json().then(function (data) {
                        alert(data.message);
                        throw new Error('validacao');
                    });
                }
                if (!res.ok) throw new Error('Erro HTTP ' + res.status);
                return res.json();
            })
            .then(function () {
                window.location.reload();
            })
            .catch(function (err) {
                if (err.message !== 'validacao') {
                    alert('Não foi possível alterar o destaque. Tente novamente.');
                }
            })
            .finally(function () {
                self.disabled = false;
            });
        });
    });

}); // fim DOMContentLoaded


/* ==========================================================================
   ADMIN — PRÉVIA DE IMAGEM (upload)
   Lê o ficheiro seleccionado e exibe-o como prévia antes do envio.
   Usa os IDs padrão: image-preview, upload-placeholder, image-preview-container
   ========================================================================= */
window.previewImage = function (event, previewId, containerId, placeholderId) {
    var file = event.target.files[0];
    if (!file) return;

    var imgEl       = document.getElementById(previewId || 'image-preview');
    var placeholder = document.getElementById(placeholderId || 'upload-placeholder');
    var container   = document.getElementById(containerId || 'image-preview-container');
    if (!imgEl) return;

    var reader = new FileReader();
    reader.onload = function (e) {
        imgEl.src = e.target.result;
        if (placeholder) placeholder.classList.add('hidden');
        if (container)   container.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
};


/* ==========================================================================
   ADMIN — PRÉVIA DE FOTO (secretarias)
   Usa o id foto-preview e aceita o input element directamente
   ========================================================================= */
window.previewFoto = function (input) {
    if (!input.files || !input.files[0]) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        var preview = document.getElementById('foto-preview');
        if (preview) preview.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
};


/* ==========================================================================
   ADMIN — TOGGLE DE STATUS (toggle-switch UI)
   Chamado via onclick nos botões de switch nas listagens do painel.
   Lê a cor activa a partir da classe focus-visible:ring-[COLOR]-500.
   Lê o nome da entidade a partir do atributo title do botão.
   ========================================================================= */
window.toggleStatus = function (btn, url) {
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta || !url) return;

    /* Detecta a cor da entidade via classe focus-visible:ring-*-500 */
    var colorMatch = btn.className.match(/focus-visible:ring-([a-z]+)-500/);
    var color      = colorMatch ? colorMatch[1] : 'blue';

    /* Extrai o nome da entidade do atributo title ("Desativar banner" → "banner") */
    var titleWords  = (btn.title || '').split(' ');
    var entityName  = titleWords.length > 1 ? titleWords[titleWords.length - 1] : 'item';

    var span  = btn.querySelector('span');
    var label = btn.parentElement ? btn.parentElement.querySelector('.toggle-label') : null;

    btn.disabled = true;
    btn.classList.add('opacity-50', 'cursor-not-allowed');

    fetch(url, {
        method:  'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfMeta.content,
            'Accept':       'application/json',
        },
    })
    .then(function (res) {
        if (!res.ok) throw new Error('Erro HTTP ' + res.status);
        return res.json();
    })
    .then(function (data) {
        var isAtivo = data.ativo;

        btn.setAttribute('aria-checked', isAtivo ? 'true' : 'false');
        btn.title = isAtivo ? ('Desativar ' + entityName) : ('Ativar ' + entityName);

        btn.classList.toggle('bg-' + color + '-500', isAtivo);
        btn.classList.toggle('bg-slate-300', !isAtivo);

        if (span) {
            span.classList.toggle('translate-x-6', isAtivo);
            span.classList.toggle('translate-x-1', !isAtivo);
        }

        if (label) {
            label.textContent = isAtivo ? 'ATIVO' : 'INATIVO';
            label.classList.toggle('text-' + color + '-600', isAtivo);
            label.classList.toggle('text-slate-400', !isAtivo);
        }
    })
    .catch(function () {
        alert('Não foi possível alterar o status. Tente novamente.');
    })
    .finally(function () {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
    });
};
