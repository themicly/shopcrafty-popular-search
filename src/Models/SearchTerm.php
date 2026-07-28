<?php

namespace Themicly\Shopcrafty\PopularSearch\Models;

use Illuminate\Database\Eloquent\Model;

class SearchTerm extends Model
{
    protected $table = 'catalog_search_terms';
    protected $fillable = ['term', 'count', 'last_searched_at'];

    protected function casts(): array
    {
        return ['count' => 'integer', 'last_searched_at' => 'datetime'];
    }
}
