<?php

namespace Themicly\Shopcrafty\PopularSearch\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Themicly\Shopcrafty\PopularSearch\Models\SearchTerm;

class SearchTerms extends Component
{
    use WithPagination;
    #[Url] public string $search = '';
    #[Url] public string $sort = 'count';
    #[Url] public int $perPage = 25;

    public function mount(): void { abort_unless(auth()->user()?->can('manage-config'), 403); }
    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedSort(): void { $this->resetPage(); }
    public function updatedPerPage(): void { $this->resetPage(); }

    public function render()
    {
        $terms = SearchTerm::query()->when($this->search !== '', fn ($q) => $q->where('term', 'like', "%{$this->search}%"))->when($this->sort === 'recent', fn ($q) => $q->orderByDesc('last_searched_at'), fn ($q) => $q->orderByDesc('count')->orderByDesc('last_searched_at'))->paginate($this->perPage);
        return view('popularsearch::livewire.search-terms', ['terms' => $terms, 'distinctTerms' => SearchTerm::count(), 'totalSearches' => (int) SearchTerm::sum('count'), 'topTerm' => SearchTerm::orderByDesc('count')->first()]);
    }
}
