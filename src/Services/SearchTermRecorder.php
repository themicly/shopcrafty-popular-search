<?php

namespace Themicly\Shopcrafty\PopularSearch\Services;

use Illuminate\Support\Facades\DB;
use Themicly\Shopcrafty\Core\Support\DemoMode;

class SearchTermRecorder
{
    public const MAX_LENGTH = 120;
    private const SESSION_KEY = 'catalog.recorded_search_terms';
    private const SESSION_LIMIT = 100;

    public function record(?string $raw): void
    {
        if (DemoMode::enabled()) {
            return;
        }

        $term = $this->normalize($raw);
        if ($term === '') return;
        $seen = (array) session()->get(self::SESSION_KEY, []);
        if (in_array($term, $seen, true)) return;
        session()->put(self::SESSION_KEY, array_slice([...$seen, $term], -self::SESSION_LIMIT));
        $now = now();
        DB::table('catalog_search_terms')->insertOrIgnore(['term' => $term, 'count' => 0, 'last_searched_at' => $now, 'created_at' => $now, 'updated_at' => $now]);
        DB::table('catalog_search_terms')->where('term', $term)->increment('count', 1, ['last_searched_at' => $now, 'updated_at' => $now]);
    }

    public function normalize(?string $raw): string
    {
        return mb_substr(mb_strtolower((string) preg_replace('/\s+/u', ' ', trim((string) $raw))), 0, self::MAX_LENGTH);
    }
}
