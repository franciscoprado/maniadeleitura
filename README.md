# Mania de Leitura

Site de e-commerce WordPress para a livraria **Mania de Leitura**, especializada em livros físicos e digitais.

---

## Stack

| Camada | Tecnologia |
|---|---|
| **Servidor web** | Nginx (stable-alpine) |
| **Backend** | PHP 8.5-FPM com WordPress |
| **Banco de dados** | MySQL 8.0 |
| **Tema** | [Sage 11](https://roots.io/sage/) + [Acorn](https://github.com/roots/acorn) ^6.2 |
| **Templating** | Laravel Blade |
| **CSS** | [Tailwind CSS](https://tailwindcss.com/) ^4 |
| **Bundler** | [Vite](https://vitejs.dev/) ^8 |
| **E-commerce** | WooCommerce |

---

## Pré-requisitos

- Docker e Docker Compose
- PHP >= 8.3 (para comandos Composer fora do container)
- Composer
- Node ^20.19.0 \|\| >=22.12.0
- WP-CLI (instalado no container Docker)

---

## Estrutura do projeto

```
.
├── docker-compose.yml        # Stack: MySQL, PHP, Nginx, phpMyAdmin
├── .env.example              # Modelo de variáveis de ambiente
├── nginx/
│   └── default.conf          # Configuração do Nginx
├── php/
│   ├── Dockerfile            # PHP 8.5-FPM com Xdebug e WP-CLI
│   └── php.ini               # Configurações PHP customizadas
└── wordpress/                # Instalação completa do WordPress
    └── wp-content/
        └── themes/
            └── maniadeleitura/   # Tema customizado (único diretório versionado)
```

> **Git scope**: Apenas `wordpress/wp-content/themes/maniadeleitura/` é versionado. Core do WordPress, plugins, uploads e outros temas são ignorados.

---

## Setup do ambiente

### 1. Variáveis de ambiente

```bash
cp .env.example .env
# Edite as senhas no .env antes de prosseguir
```

### 2. Iniciar containers

```bash
docker compose up -d
```

A stack sobe quatro serviços:

| Serviço | Acesso |
|---|---|
| **WordPress** | http://localhost:8080 |
| **phpMyAdmin** | http://localhost:8081 |
| **MySQL** | interno (host: `db`, porta `3306`) |
| **PHP-FPM** | interno (porta `9000`) |

### 3. Instalar dependências do tema

```bash
cd wordpress/wp-content/themes/maniadeleitura
composer install
npm install
```

---

## Desenvolvimento

### Servidor Vite com HMR

```bash
cd wordpress/wp-content/themes/maniadeleitura
npm run dev
```

### Build de produção

```bash
npm run build
```

### Comandos do tema

| Comando | Descrição |
|---|---|
| `npm run dev` | Vite dev server com hot-reload |
| `npm run build` | Build de produção |
| `npm run translate` | Gera/atualiza arquivos .pot e .po |
| `npm run translate:compile` | Compila .mo e .json a partir dos .po |
| `composer install` | Instala dependências PHP (Acorn, WooCommerce) |

---

## Arquitetura do tema

### Bootstrap

```
functions.php
  → Composer autoload
  → Acorn Application::configure() com ThemeServiceProvider
  → app/setup.php    (sidebars, menus, suporte ao tema, theme.json)
  → app/filters.php   (hooks e filtros — WooCommerce, excerpt)
  → index.php         (echo view(app('sage.view'), app('sage.data')))
```

O tema segue o padrão **PSR-4** com namespace `App\` mapeado para `app/`.

### Views Blade

```
resources/views/
├── layouts/app.blade.php       # Layout principal (HTML5)
├── partials/                   # Fragmentos: header, footer, sidebar, comments, etc.
├── components/                 # Componentes Blade reutilizáveis
├── sections/                   # Seções: header, footer, sidebar
├── woocommerce/                # Templates Blade para loja e produto
├── 404.blade.php
├── index.blade.php
├── page.blade.php
├── search.blade.php
└── single.blade.php
```

### View Composers

Injetam dados automaticamente nas views Blade:

| Composer | Dados injetados | Escopo |
|---|---|---|
| `App\View\Composers\App` | `$siteName` | Todas as views |
| `App\View\Composers\Post` | `$title`, `$pagination` | Posts e páginas |
| `App\View\Composers\Comments` | `$title`, `$responses`, `$previous`, `$next` | Comentários |

---

## WooCommerce

- **Templates Blade**: `archive-product.blade.php`, `single-product.blade.php`
- **Templates PHP** (para compatibilidade com `wc_get_template_part`): `content-product.php`, `content-single-product.php`
- **Hooks substituídos** em `app/filters.php`: título, avaliação, preço, excerpt, botão comprar, meta e compartilhamento — todos com implementação própria do tema

---

## Theme.json

`theme.json` na raiz do tema é o **arquivo fonte**. Durante o build, o `@roots/vite-plugin` mescla as cores, fontes e tamanhos do Tailwind e gera o arquivo final em `public/build/assets/theme.json`. O `setup.php` redireciona o WordPress para a versão gerada via filtro `theme_file_path`.

---

## Tradução

```bash
cd wordpress/wp-content/themes/maniadeleitura

# Gerar .pot e atualizar .po
npm run translate

# Compilar .mo e .json
npm run translate:compile
```

> Domínio de texto: `sage` (herdado do Roots/Sage, não `maniadeleitura`).

---

## Linting e testes

- **PHP**: `vendor/bin/pint` ([Laravel Pint](https://github.com/laravel/pint))
- **JavaScript/CSS**: nenhum linter configurado
- **Testes**: nenhum framework configurado, sem CI/CD

---

## Configurações relevantes

### PHP (`php/php.ini`)

- `memory_limit = 256M`
- `upload_max_filesize = 64M`, `post_max_size = 64M`
- `max_input_vars = 3000`
- `max_execution_time = 300`
- OPcache habilitado
- Xdebug configurado (modo: develop, coverage, debug, profile; porta 9003)
- Timezone: `America/Sao_Paulo`

### Nginx (`nginx/default.conf`)

- `client_max_body_size 100M`
- Cache máximo para assets estáticos (CSS, JS, imagens)

### Vite (`vite.config.js`)

- Base path: `/app/themes/sage/public/build/` (convenção Sage, resolvido em runtime pelo `@roots/vite-plugin`)
- Plugins: `@tailwindcss/vite`, `laravel-vite-plugin`, `@roots/vite-plugin`
- Aliases: `@scripts`, `@styles`, `@fonts`, `@images`
- `APP_URL` padrão: `http://example.test` (configurar no ambiente para produção)

---

## Licença

MIT — [Roots Software LLC](https://roots.io/)
