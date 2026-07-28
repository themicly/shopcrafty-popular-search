<?php

namespace Themicly\Shopcrafty\PopularSearch;

use Themicly\Shopcrafty\Core\Module\ModuleServiceProvider;
use Themicly\Shopcrafty\PopularSearch\Services\SearchTermRecorder;

final class PopularSearchServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string
    {
        return 'PopularSearch';
    }

    protected function modulePath(): string
    {
        return __DIR__;
    }

    protected function bootModule(): void
    {
        $this->addonRegistry()->register('popular-search', [
            'name' => 'Popular and trending search terms',
            'provider' => self::class,
            'recorder' => SearchTermRecorder::class,
        ]);
        $this->addonRegistry()->registerSettingsSchema('popular-search', [
            'label' => 'Popular search settings',
            'fields' => ['search.popular_terms'],
        ]);
    }
}
