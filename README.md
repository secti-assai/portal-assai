**1. Clonar o repositório**
git clone [https://github.com/seu-usuario/portal-assai.git](https://github.com/seu-usuario/portal-assai.git)
cd portal-assai

2. Instalar dependências de Back-end
composer install --optimize-autoloader --no-dev # Para produção
# ou
composer install # Para desenvolvimento local

3. Compilar dependências de Front-end
npm install
npm run build

4. Configuração de Variáveis de Ambiente
cp .env.example .env
php artisan key:generate
Atenção: Edite o ficheiro .env informando as credenciais de DB_CONNECTION (PostgreSQL) e as chaves de MAIL_MAILER (SMTP).

5. Executar Migrações e Dados Base
php artisan migrate --seed
(As seeders são obrigatórias para injetar as Roles de ACL, Permissões base e a conta de Administrador do sistema).

6. Configurar Sistema de Ficheiros
php artisan storage:link

7. Servidor Local (Ambiente de Desenvolvimento)
php artisan serve
# Num terminal paralelo, execute para compilação contínua do Tailwind:
npm run dev

Diretrizes de Engenharia e Boas Práticas
Transações de Banco de Dados: Todas as operações de escrita múltiplas ou destrutivas nos controladores operam sob DB::beginTransaction() e DB::commit(), protegidas por blocos try-catch para evitar falhas silenciosas.

Validação (Security-first): Não utilize validação inline. Todos os inputs são filtrados através de classes FormRequest independentes.

Arquitetura CSS: O interface é estritamente construído sobre classes utilitárias do Tailwind CSS. Estilos compostos ou arbitrários fora do fluxo do tailwind.config.js devem ser evitados para garantir a manutenibilidade transversal do design system.

Licença e Propriedade
Este software é de uso restrito e propriedade da Prefeitura Municipal de Assaí. É terminantemente proibida a cópia, distribuição, ou execução deste código em infraestruturas não autorizadas pelo departamento de Tecnologia do Município.
