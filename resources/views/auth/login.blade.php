<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Panel Admin</title>

    {{-- SOLO LOGIN.CSS – SIN TAILWIND --}}
    @vite('resources/css/login.css')
</head>
<body>

    <div class="glass-card">

        <h2 style="text-align:center; margin-bottom:10px;">Panel Administrativo</h2>
        <p style="text-align:center; margin-bottom:20px;">Inicia sesión para continuar</p>

        @if($errors->any())
        <div style="background:rgba(255,0,0,0.4); padding:10px; border-radius:10px; margin-bottom:15px;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label>Correo electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="correo@ejemplo.com">

            <label style="margin-top: 15px;">Contraseña</label>
            <input type="password" name="password" required placeholder="********">

            <button type="submit">Iniciar Sesión</button>
        </form>

    </div>

</body>
</html>
