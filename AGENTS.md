# AGENTS.md — Mania de Leitura

## What this is

WordPress e-commerce (WooCommerce) site using the **Sage 11** starter theme with **Laravel Acorn** (Blade templating, IoC container), **Tailwind CSS v4**, and **Vite 8** for the frontend build.

## Git scope

Only `wordpress/wp-content/themes/maniadeleitura/` is tracked. Core WP, plugins, uploads, and unrelated themes are gitignored at the root. All development happens inside the theme directory.

## Dev environment

```sh
docker compose up -d               # Start stack (MySQL 8, PHP 8.5-FPM, Nginx, phpMyAdmin)
# WP frontend: http://localhost:8080
# phpMyAdmin:  http://localhost:8081
```

Theme dev commands (run from `wordpress/wp-content/themes/maniadeleitura/`):

| Command | Purpose |
|---|---|
| `npm run dev` | Vite dev server with HMR |
| `npm run build` | Production Vite build |
| `npm run translate` | Generate/update `.pot` then update `.po` |
| `npm run translate:compile` | Build `.mo` + `.json` from `.po` |
| `composer install` | Install PHP deps (Acorn, WooCommerce, wp-cli) |

Node: `^20.19.0 \|\| >=22.12.0`. PHP: `>=8.3`.

## Architecture

- **Boot flow**: `functions.php` → Composer autoload → Acorn `Application::configure()` with `ThemeServiceProvider` → loads `app/setup.php` + `app/filters.php`
- **PSR-4 namespace**: `App\` maps to `app/`
- **Blade views**: `resources/views/`, layouts in `layouts/`, partials in `partials/`, components in `components/`
- **View composers**: `App/View/Composers/` inject data (site name, post data, comments) into Blade views
- **Build output**: Vite writes to `public/build/` (gitignored except `.gitkeep`)

## Theme.json

`theme.json` at theme root is a **source file**. The real generated file lives at `public/build/assets/theme.json` — produced by `@roots/vite-plugin`'s `wordpressThemeJson` plugin, which merges Tailwind colors/fonts/sizes into the block editor palette. `setup.php` redirects WP to the generated file via `theme_file_path` filter.

## WooCommerce

- Custom **Blade templates**: `resources/views/woocommerce/archive-product.blade.php`, `single-product.blade.php`
- **Raw PHP** templates: `content-product.php`, `content-single-product.php` (WooCommerce's `wc_get_template_part()` does not support Blade)
- Hook overrides in `app/filters.php`: removes default WooCommerce loop callbacks on `init` and replaces them with theme-specific ones (`maniadeleitura_shop_loop_item_title`, `maniadeleitura_after_shop_loop_item_title`, `maniadeleitura_after_shop_loop_item`)

## Code style

`.editorconfig` enforces:
- PHP: 4-space indent, single quotes
- Blade/CSS/JS: 2-space indent, single quotes
- LF line endings, UTF-8, final newline

Text domain is `sage` (inherited from Roots/Sage), not the theme name.

## Testing / linting

- **No test framework** configured. No CI/CD.
- PHP linter available: `vendor/bin/pint` (via `laravel/pint` dev dependency)
- No JS linting configured.

## Key gotchas

- Vite `base` is `/app/themes/sage/public/build/` (Sage convention, not a filesystem path — resolved by `@roots/vite-plugin` at runtime)
- `APP_URL` defaults to `http://example.test` if unset (hardcoded in `vite.config.js`); set it in `.env` or environment for production builds
- Debug mode is off: `WP_DEBUG` is `false` in `wp-config.php`
- Root `.env` uses placeholder passwords (`change_me_root`, `change_me_wp`)
