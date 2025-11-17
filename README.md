# HOTEL & EVENTOS SYSTEM
Laravel 11 + Blade + Tailwind + Alpine + Vite

## Requisitos
- PHP 8.3, Composer 2.x
- MySQL/MariaDB
- Node 18+

## Instalación rápida
```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
Abrir: http://127.0.0.1:8000/install

### Paquetes
- spatie/laravel-permission
- barryvdh/laravel-dompdf
- laravel/breeze (para auth + Tailwind)
