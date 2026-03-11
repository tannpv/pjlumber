# CLAUDE.md — PJLumber.com Project Instructions

## Project Overview
Joomla CMS website for PJ Lumber.

## Architecture
- **CMS**: Joomla (PHP-based)
- `configuration.php` — Joomla config (DB credentials, site settings)
- `administrator/` — Joomla admin panel
- `components/` — Joomla components
- `modules/` — Joomla modules
- `plugins/` — Joomla plugins
- `templates/` — site templates
- `images/` — uploaded media
- `db-bk.sql` — database backup

## Deployment
- **GitHub repo**: https://github.com/tannpv/pjlumber (private)
- **Pipeline**: Push to `master` → GitHub Actions → rsync to SiteGround
- **Production**: SiteGround (gtxm1049.siteground.biz)
- Do NOT push to production without explicit confirmation

## Important Notes
- Default branch is `master` (not main)
- `configuration.php` contains DB credentials — handle with care
- `db-bk.sql` is excluded from deployment (database backup)
- Joomla needs a MySQL/MariaDB database configured on SiteGround
