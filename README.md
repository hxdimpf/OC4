# OC4 — OpenCaching Symfony Frontend

Next-generation frontend for the opencaching platform. Symfony 7.x, PHP 8.4,
vanilla ES modules, self-hosted vendor libraries.

## Quick Start

    git clone git@github.com:hxdimpf/OC4.git
    cd OC4
    ddev start
    ddev composer install

The app is now running at `https://oc4.ddev.site`.

## Architecture

- **Framework:** Symfony 7.x, Doctrine DBAL (no ORM), Doctrine Migrations
- **Templates:** Twig under `templates/`
- **Frontend:** vanilla ES modules under `public/js/`, self-hosted vendor under `public/vendor/`
- **No Webpack/Encore** — bundling was removed; the page loads modules directly
- **DB:** MariaDB; legacy OC schema

## Localization

Translations in `translations/messages+intl-icu.{en,de}.yaml`. 
The `check-yaml-duplicates.py` script in `scripts/` validates keys.

## License

See [LICENSE.md](LICENSE.md).
