<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryItemRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'sku' => 'nullable|string|max:80',
            'name' => 'required|string|max:191',
            'category' => 'nullable|string|max:191',
            'quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
