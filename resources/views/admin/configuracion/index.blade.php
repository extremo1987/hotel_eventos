@extends('layouts.app')

@section('title', 'Configuración del Sistema')

@section('content')

<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 max-w-6xl mx-auto"
     x-data="{ empresa:true, logo:false, factura:false, impuesto:false, descuento:false }">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            ⚙️ Configuración del Sistema
        </h2>

        <a href="{{ route('admin.dashboard') }}"
           class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200">
            ← Volver
        </a>
    </div>


    @if(session('ok'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded-lg">
            {{ session('ok') }}
        </div>
    @endif



    {{-- FORMULARIO PRINCIPAL --}}
    <form action="{{ route('config.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf




        {{-- =======================================================
              🏢 DATOS DE LA EMPRESA
        ======================================================== --}}
        <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <button type="button"
                    @click="empresa = !empresa"
                    class="w-full flex justify-between items-center px-5 py-4 bg-gray-50 hover:bg-gray-100 transition">
                <span class="font-semibold text-gray-900 text-lg">🏢 Datos de la Empresa</span>
                <span class="text-gray-600 text-sm" x-text="empresa ? 'Ocultar ▲' : 'Mostrar ▼'"></span>
            </button>


            <div x-show="empresa" x-transition class="p-6 space-y-6 bg-white">

                <div class="grid sm:grid-cols-2 gap-6">

                    {{-- Nombre --}}
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-600 mb-1">Nombre de la Empresa</label>
                        <input id="company_name" name="company_name" type="text"
                               value="{{ setting('company_name') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                               placeholder="Ej. Hotel Real">
                    </div>

                    {{-- RTN --}}
                    <div>
                        <label for="company_rtn" class="block text-sm font-medium text-gray-600 mb-1">RTN</label>
                        <input id="company_rtn" name="company_rtn" type="text"
                               value="{{ setting('company_rtn') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                               placeholder="Ej. 08011999012345">
                    </div>

                </div>

                {{-- Dirección --}}
                <div>
                    <label for="company_address" class="block text-sm font-medium text-gray-600 mb-1">Dirección</label>
                    <textarea id="company_address" name="company_address" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                     focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                              placeholder="Ej. Barrio Centro, SPS">{{ setting('company_address') }}</textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-6">

                    {{-- Teléfono --}}
                    <div>
                        <label for="company_phone" class="block text-sm font-medium text-gray-600 mb-1">Teléfono</label>
                        <input id="company_phone" name="company_phone" type="text"
                               value="{{ setting('company_phone') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                               placeholder="Ej. 9999-9999">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="company_email" class="block text-sm font-medium text-gray-600 mb-1">Correo electrónico</label>
                        <input id="company_email" name="company_email" type="email"
                               value="{{ setting('company_email') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                               placeholder="Ej. contacto@hotel.com">
                    </div>

                </div>

            </div>
        </div>




        {{-- =======================================================
              🖼️ LOGO
        ======================================================== --}}
        <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <button type="button"
                    @click="logo = !logo"
                    class="w-full flex justify-between items-center px-5 py-4 bg-gray-50 hover:bg-gray-100 transition">
                <span class="font-semibold text-gray-900 text-lg">🖼️ Logo de la Empresa</span>
                <span class="text-gray-600 text-sm" x-text="logo ? 'Ocultar ▲' : 'Mostrar ▼'"></span>
            </button>


            <div x-show="logo" x-transition class="p-6 space-y-4">

                @if(setting('company_logo'))
                    <img src="{{ asset(setting('company_logo')) }}"
                         class="h-20 rounded border p-1 shadow bg-white">
                @endif

                <input type="file" name="company_logo" class="text-sm text-gray-700">
            </div>

        </div>




        {{-- =======================================================
              🧾 FACTURACIÓN
        ======================================================== --}}
        <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <button type="button"
                    @click="factura = !factura"
                    class="w-full flex justify-between items-center px-5 py-4 bg-gray-50 hover:bg-gray-100 transition">
                <span class="font-semibold text-gray-900 text-lg">🧾 Facturación</span>
                <span class="text-gray-600 text-sm" x-text="factura ? 'Ocultar ▲' : 'Mostrar ▼'"></span>
            </button>


            <div x-show="factura" x-transition class="p-6 space-y-6">

                <div class="grid sm:grid-cols-2 gap-6">

                    {{-- Prefijo --}}
                    <div>
                        <label for="invoice_prefix" class="block text-sm font-medium text-gray-600 mb-1">Prefijo</label>
                        <input id="invoice_prefix" name="invoice_prefix" type="text"
                               value="{{ setting('invoice_prefix', 'FAC-') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                               placeholder="Ej. FAC-">
                    </div>

                    {{-- Número inicial --}}
                    <div>
                        <label for="invoice_start_number" class="block text-sm font-medium text-gray-600 mb-1">
                            Número inicial
                        </label>
                        <input id="invoice_start_number" name="invoice_start_number" type="number"
                               value="{{ setting('invoice_start_number',1) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                               placeholder="1">
                    </div>

                </div>
            </div>

        </div>




        {{-- =======================================================
            💰 IMPUESTOS
        ======================================================== --}}
        <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <button type="button"
                    @click="impuesto = !impuesto"
                    class="w-full flex justify-between items-center px-5 py-4 bg-gray-50 hover:bg-gray-100 transition">
                <span class="font-semibold text-gray-900 text-lg">💰 Impuestos</span>
                <span class="text-gray-600 text-sm" x-text="impuesto ? 'Ocultar ▲' : 'Mostrar ▼'"></span>
            </button>


            <div x-show="impuesto" x-transition class="p-6 space-y-6">

                <div class="grid sm:grid-cols-2 gap-6">

                    {{-- ISV 15 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">ISV 15%</label>
                        <select name="tax_15_enabled"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <option value="1" {{ setting('tax_15_enabled',1)==1 ? 'selected':'' }}>Activado</option>
                            <option value="0" {{ setting('tax_15_enabled')==0 ? 'selected':'' }}>Desactivado</option>
                        </select>
                    </div>

                    {{-- ISV 18 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">ISV 18%</label>
                        <select name="tax_18_enabled"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <option value="1" {{ setting('tax_18_enabled',1)==1 ? 'selected':'' }}>Activado</option>
                            <option value="0" {{ setting('tax_18_enabled')==0 ? 'selected':'' }}>Desactivado</option>
                        </select>
                    </div>

                </div>

                {{-- Impuesto extra --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Impuesto Extra (%)</label>
                    <input name="extra_tax" type="number" step="0.01"
                           value="{{ setting('extra_tax',0) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                           placeholder="0.00">
                </div>

            </div>

        </div>




        {{-- =======================================================
            🔻 DESCUENTOS
        ======================================================== --}}
        <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <button type="button"
                    @click="descuento = !descuento"
                    class="w-full flex justify-between items-center px-5 py-4 bg-gray-50 hover:bg-gray-100 transition">
                <span class="font-semibold text-gray-900 text-lg">🔻 Descuentos</span>
                <span class="text-gray-600 text-sm" x-text="descuento ? 'Ocultar ▲' : 'Mostrar ▼'"></span>
            </button>


            <div x-show="descuento" x-transition class="p-6 space-y-6">

                {{-- Activar o no --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Habilitar descuento</label>
                    <select name="discount_enabled"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                        <option value="1" {{ setting('discount_enabled',1)==1 ? 'selected':'' }}>Activado</option>
                        <option value="0" {{ setting('discount_enabled')==0 ? 'selected':'' }}>Desactivado</option>
                    </select>
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tipo de Descuento</label>
                    <select name="discount_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                        <option value="percentage" {{ setting('discount_type')=='percentage' ? 'selected':'' }}>
                            Porcentaje (%)
                        </option>
                        <option value="fixed" {{ setting('discount_type')=='fixed' ? 'selected':'' }}>
                            Monto fijo (L)
                        </option>
                    </select>
                </div>

                {{-- Valor --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Valor de descuento</label>
                    <input name="discount_value" type="number" step="0.01"
                           value="{{ setting('discount_value',0) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                           placeholder="0.00">
                </div>

            </div>

        </div>




        {{-- =======================================================
            BOTONES
        ======================================================== --}}
        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
            <button type="submit"
                    class="px-6 py-3 rounded-lg bg-blue-600 text-white font-medium shadow
                           hover:bg-blue-700 transition">
                Guardar Cambios
            </button>

            <a href="{{ route('admin.dashboard') }}"
               class="px-6 py-3 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection
