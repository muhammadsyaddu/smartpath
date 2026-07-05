<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade directive: @role('administrator')
        Blade::if('role', function (string $peran) {
            return auth()->check() && auth()->user()->peran === $peran;
        });

        // Blade directive: @admin
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        // Blade directive: @dinas
        Blade::if('dinas', function () {
            return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDinas());
        });

        // Custom validator: valid coordinate pair
        Validator::extend('valid_coordinates', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $lat = $data['latitude'] ?? null;
            $lng = $data['longitude'] ?? null;

            if ($lat === null || $lng === null) {
                return false;
            }

            return $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180;
        }, 'Koordinat tidak valid.');

        // Custom validator: bobot total = 1.00
        Validator::extend('bobot_total', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $total = (float) ($data['bobot_keparahan'] ?? 0)
                + (float) ($data['bobot_pelapor'] ?? 0)
                + (float) ($data['bobot_fasilitas'] ?? 0);

            return round($total, 2) === 1.00;
        }, 'Total bobot keparahan, pelapor, dan fasilitas harus sama dengan 1.00.');
    }
}