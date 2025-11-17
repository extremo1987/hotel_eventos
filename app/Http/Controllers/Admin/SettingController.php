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
        $request->validate([
            'company_name'  => 'required|string|max:255',
            'company_rtn'   => 'required|string|max:255',
            'company_logo'  => 'nullable|image|max:2048',
        ]);

        $settings = Setting::first() ?? new Setting();

        // LOGO
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $name = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/config', $name);
            $settings->company_logo = 'storage/config/' . $name;
        }

        // CAMPOS GENERALES
        $settings->company_name = $request->company_name;
        $settings->company_rtn = $request->company_rtn;
        $settings->company_phone = $request->company_phone;
        $settings->company_email = $request->company_email;
        $settings->company_address = $request->company_address;

        // FACTURACIÓN
        $settings->invoice_prefix = $request->invoice_prefix;
        $settings->invoice_start_number = $request->invoice_start_number;

        $settings->save();

        return back()->with('ok', 'Configuración actualizada correctamente.');
    }
}
