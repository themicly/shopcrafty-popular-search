<?php

use Illuminate\Support\Facades\Route;

Route::view('/reports/search-terms', 'popularsearch::admin.search-terms')->middleware('can:manage-config')->name('reports.search-terms');
