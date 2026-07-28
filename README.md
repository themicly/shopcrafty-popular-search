# Shopcrafty Popular Search

Popular search terms and storefront search analytics for Shopcrafty.

## Requirements

- PHP 8.3+
- Laravel 13+
- `themicly/shopcrafty` 1.0+

## Installation

```bash
composer require themicly/shopcrafty-popular-search
php artisan migrate
```

The package is auto-discovered by Laravel. Popular search terms remain
configured through Admin → Themes → Storefront settings when the addon is
installed.

## Features

- Normalizes search terms by trimming, collapsing whitespace, and lowercasing
- Counts each term once per visitor session
- Ignores search analytics in Shopcrafty demo mode
- Records explicit searches and settled predictive-search queries
- Admin report at `/admin/reports/search-terms`
- Popular-term settings metadata for the Shopcrafty settings UI

The report supports filtering, popularity/recent sorting, and pagination.

## Views and services

- Views use the `popularsearch::` namespace
- `SearchTermRecorder` records normalized terms
- `SearchTerm` reads aggregated terms from `catalog_search_terms`
- `popularsearch.search-terms` is the Livewire report component

## License

MIT. Targets PHP 8.3+ and Laravel 13+.
