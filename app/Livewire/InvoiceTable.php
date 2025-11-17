<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice;

class InvoiceTable extends Component
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

    // Cambiar ordenamiento
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
        $facturas = Invoice::with('client')
            ->where(function($q) {
                $q->where('invoice_number', 'like', "%{$this->search}%")
                  ->orWhereHas('client', fn($c) =>
                        $c->where('name', 'like', "%{$this->search}%")
                    );
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.invoice-table', compact('facturas'));
    }
}
