<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $setting = Setting::first();

            if ($setting && $setting->auto_update_status && $setting->event_start && $setting->event_end) {
                $now = now();
                $start = \Carbon\Carbon::parse($setting->event_start);
                $end = \Carbon\Carbon::parse($setting->event_end);

                $newStatus = $setting->event_status;

                if ($now->lt($start)) {
                    $newStatus = 'upcoming';
                } elseif ($now->between($start, $end)) {
                    $newStatus = 'ongoing';
                } else {
                    $newStatus = 'finished';
                }

                if ($newStatus !== $setting->event_status) {
                    $setting->update(['event_status' => $newStatus]);
                }
            }

            $view->with('setting', $setting);
        });
    }
}
