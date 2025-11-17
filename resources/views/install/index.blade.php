@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Asistente de instalación</h1>
<form method="POST" action="{{ route('install.store') }}" class="grid gap-3 max-w-lg">
  @csrf
  <input name="company" class="border p-2 rounded" placeholder="Nombre de la empresa" required>
  <input type="email" name="admin_email" class="border p-2 rounded" placeholder="Correo administrador" required>
  <input type="password" name="password" class="border p-2 rounded" placeholder="Contraseña" required>
  <label class="inline-flex items-center gap-2"><input type="checkbox" name="demo" value="1"> Cargar datos demo</label>
  <button class="px-4 py-2 border rounded">Instalar</button>
</form>
@endsection
