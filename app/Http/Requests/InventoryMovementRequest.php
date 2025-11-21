<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryMovementRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'type' => 'required|in:entrada,salida,ajuste',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'responsible' => 'nullable|string|max:191',
            'unit_price' => 'nullable|numeric|min:0',
        ];
    }
}
