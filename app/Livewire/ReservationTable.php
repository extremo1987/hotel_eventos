<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;

class ReservationTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $queryString = ['search'];

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
        $reservas = Reservation::with(['client', 'salon'])
            ->where(function ($q) {
                $q->whereHas('client', fn($c) => $c->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('salon', fn($s) => $s->where('name', 'like', "%{$this->search}%"))
                  ->orWhere('status', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(8);

        return view('livewire.reservation-table', compact('reservas'));
    }
}
