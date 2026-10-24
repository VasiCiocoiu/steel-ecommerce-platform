# Steel E-commerce Platform

B2B e-commerce REST API for ordering custom-cut steel/metal pieces: companies, products, stock, warehouses, custom dimensions, orders, billing, deliveries and an in-app chat between client and provider. Built with **Symfony** (API Platform, Doctrine) and **MongoDB** for analytics.

Capstone project ("Fil Rouge") of the CDA program at IMIE Paris, 2023-2024. **Built in a team of two** with Salman Mouhamad Bilal — see `docs/` for the diagrams produced for the project defense.

## Domain model
16 entities covering the full order lifecycle: `Company`, `User`, `Product`, `Dimension`, `Stock`, `Warehouse`, `Provider`, `OrderLine`, `Delivery`, `Bill`/`BillLine`, `Discussion`/`Message`, `Visitor`, plus a MongoDB `Analytics` document for visit tracking.

## Diagrams
- `docs/3tier.png` — overall 3-tier architecture
- `docs/mcd.png`, `docs/MLD.png` — data model (conceptual / logical)
- `docs/class_diag.png`, `docs/use_case.png`, `docs/sequence_diag.png`, `docs/authUml.png` — UML
- `docs/desktop_maquette.png`, `docs/mobile_maquette.png`, `docs/web_backoffice_maquette.png`, `docs/web_client_maquette.png` — UI mockups

## Setup
```bash
composer install
cp .env.example .env   # adjust DB credentials
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start
```

Tests: `php bin/phpunit`. CI config in `.gitlab-ci.yml` (originally run on the school's GitLab).
