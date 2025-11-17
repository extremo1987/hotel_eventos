<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quote;

class QuoteTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $cotizaciones = Quote::with('client')
            ->where(function ($query) {
                $query->where('reference', 'like', "%{$this->search}%")
                      ->orWhere('status', 'like', "%{$this->search}%")
                      ->orWhere('total', 'like', "%{$this->search}%")
                      ->orWhereHas('client', fn($q) =>
                          $q->where('name', 'like', "%{$this->search}%")
                      );
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.quote-table', compact('cotizaciones'));
    }
}
