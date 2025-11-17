<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'sortField', 'sortDirection'];

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
        $searchTerm = strtolower(trim($this->search));

        $clientes = Client::where(function ($query) use ($searchTerm) {
                $query->where(DB::raw('LOWER(name)'), 'like', "%{$searchTerm}%")
                      ->orWhere(DB::raw('LOWER(email)'), 'like', "%{$searchTerm}%")
                      ->orWhere(DB::raw('LOWER(phone)'), 'like', "%{$searchTerm}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(8);

        return view('livewire.client-table', compact('clientes'));
    }
}
