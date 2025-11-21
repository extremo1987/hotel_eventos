<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        return view('admin.configuracion.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::first() ?? new Setting();

        // VALIDACIONES
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_rtn' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'discount_value' => 'nullable|numeric|min:0',
            'extra_tax' => 'nullable|numeric|min:0',
            'invoice_start_number' => 'nullable|integer|min:1',
        ]);

        // LOGO
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $name = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/config', $name);
            $settings->company_logo = "storage/config/{$name}";
        }

        // GUARDAR DATOS
        $settings->fill($request->only([
            'company_name', 'company_rtn', 'company_phone', 'company_email', 'company_address',
            'invoice_prefix', 'invoice_start_number',
            'tax_15_enabled', 'tax_18_enabled', 'extra_tax',
            'discount_enabled', 'discount_type', 'discount_value',
        ]));

        $settings->save();

        return back()->with('ok', 'Configuración actualizada correctamente.');
    }
}
