# Hi-Life Entertainment — WordPress Public Site

WordPress public site for [thehi-life.co.uk](https://thehi-life.co.uk), a Leeds-based DJ hire and events company operating across the North of England.

## Overview

This repository contains only the custom theme files and plugin for the Hi-Life WordPress installation. It does not include the full WordPress core, plugins (except `hilife-core`), or uploads — only the files written specifically for this project.

The site runs alongside a separate authenticated events management application (`hilife-events` repo) which handles client planners, DJ admin and booking management.

## Architecture

### Content model

Three custom taxonomies drive the site structure:

- **Occasion** — Wedding, Corporate, Private Party
- **Location** — Leeds & Yorkshire, Manchester & Cheshire, Sheffield & Derbyshire, York & Harrogate, Liverpool & Lancashire, Newcastle & North East
- **Service** — Silent Disco, Sax & DJ etc

Custom post types:
- `event` — past and upcoming events, tagged with occasion and location
- `feedback` — client testimonials, tagged with occasion and location
- `djs` — DJ roster with ACF fields for bio, summary, link
- `music-theme` — curated music sets with playlist repeater field
- `landing_page` — unique content for occasion × location intersection pages

### URL structure

- `/` — Homepage
- `/occasion/{slug}` — Occasion archive e.g. `/occasion/wedding`
- `/location/{slug}` — Location archive e.g. `/location/leeds-yorkshire`
- `/service/{slug}` — Service archive e.g. `/service/silent-disco`
- `/{occasion}/{location}` — Intersection pages e.g. `/wedding/manchester-cheshire`
- `/djs` — DJ roster
- `/music` — Music themes
- `/blog` — Blog archive
- `/contact` — Contact/enquiry form

### Events app integration

The authenticated events app lives at `/events/` within the same document root. The `.htaccess` routes planner, admin, account and auth paths to the events app while everything else goes through WordPress.

The WordPress header is shared with the events app via a REST endpoint:
`/wp-json/hilife/v1/header`

Auth state is checked via the events app endpoint:
`/auth/status`

## Custom files in this repo

### Plugin
`wp-content/plugins/hilife-core/hilife-core.php`

Handles everything custom:
- CPT and taxonomy registration
- Rewrite rules for intersection pages
- Template routing via `template_include` filter
- REST API endpoints for header and footer
- Nav menu auth state filtering
- Script and style enqueuing

### Theme (Twenty Twenty-Five child customisation)
All files sit within `wp-content/themes/twentytwentyfive/`:

- `hilife.css` — full design system, CSS variables, all component styles
- `hilife-header.css` — standalone header/footer styles loaded by the events app
- `header-hilife.php` — dynamic PHP header with auth-aware nav
- `footer-hilife.php` — dynamic PHP footer with location links
- `assets/logo.png` — Hi-Life circular logo mark
- `assets/favicon.png` — favicon
- `assets/hilife.js` — hamburger menu JS

### Templates
All in `wp-content/themes/twentytwentyfive/templates/`:

| Template | Route |
|----------|-------|
| `front-page.php` | Homepage |
| `page.php` | Standard WordPress pages (About, Privacy etc) |
| `contact.php` | Contact/enquiry form |
| `archive-blog.php` | Blog listing |
| `single-blog.php` | Individual blog post |
| `archive-dj.php` | DJ roster |
| `single-dj.php` | Individual DJ page |
| `archive-music.php` | Music themes listing |
| `single-music-theme.php` | Individual music theme with playlist |
| `taxonomy-location.php` | Location archive |
| `taxonomy-occasion.php` | Occasion archive |
| `taxonomy-service.php` | Service archive |
| `occasion-location.php` | Occasion × location intersection pages |

## Design system

Colours defined as CSS variables in `hilife.css`:

- `--accent` `#14B8A6` — primary UI accent (teal)
- `--gold` `#E3DD58` — logo mark and CTA buttons only
- `--black` `#1A1612` — page background
- `--surface` `#221E1A` — section backgrounds
- `--panel` `#2E2924` — content item backgrounds
- `--panel-border` `#4A443C` — content item borders

Typography:
- `DM Serif Display` — headings
- `DM Sans` — body
- `Lekton` — wordmark only

## Environments

| Environment | URL | WordPress DB | Events DB |
|-------------|-----|-------------|-----------|
| Local | `localhost:10006` | Local | Local |
| Dev | `dev.thehi-life.co.uk` | `hilife_wp_dev` | `hilife_events_staging` |
| Staging | `staging.thehi-life.co.uk` | `hilife_wp_staging` | `hilife_events_staging` |
| Live | `thehi-life.co.uk` | `hilife_wp_live` | `hilife_prod` |

## Deployment

Code deploys via Plesk Git integration pulling from this repository. The `.htaccess` is tracked in git and deploys automatically.

After deploying to a new environment:
1. Activate the `hilife-core` plugin
2. Install and activate ACF Pro (premium — not in repo)
3. Import WordPress database with URL search-replace
4. Flush permalinks — Settings → Permalinks → Save Changes
5. Set environment secrets in the events app

## Related repository

[hilife-events](https://github.com/alexbowen/hilife-events) — authenticated events management application
