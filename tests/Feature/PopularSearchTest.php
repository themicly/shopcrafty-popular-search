<?php

namespace Themicly\Shopcrafty\PopularSearch\Tests\Feature;

use Themicly\Shopcrafty\Core\Module\AddonRegistry;
use Themicly\Shopcrafty\PopularSearch\Models\SearchTerm;
use Themicly\Shopcrafty\PopularSearch\Services\SearchTermRecorder;
use Themicly\Shopcrafty\PopularSearch\Tests\TestCase;

final class PopularSearchTest extends TestCase
{
    public function test_addon_registers_recorder_and_report_route(): void
    {
        $addon = app(AddonRegistry::class)->all()['popular-search'] ?? [];

        $this->assertSame(SearchTermRecorder::class, $addon['recorder'] ?? null);
        $this->assertTrue(route('admin.reports.search-terms') !== '');
        $this->assertTrue(view()->exists('popularsearch::livewire.search-terms'));
    }

    public function test_search_terms_are_normalized_and_counted_once_per_session(): void
    {
        $this->artisan('migrate');
        $recorder = app(SearchTermRecorder::class);

        $this->assertSame('red shoes', $recorder->normalize("  RED   shoes \n"));
        $recorder->record(' RED   shoes ');
        $recorder->record('red shoes');

        $this->assertSame(1, SearchTerm::where('term', 'red shoes')->value('count'));
    }
}
