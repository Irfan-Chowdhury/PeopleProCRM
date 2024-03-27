<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class ViewComposerServiceProvider extends ServiceProvider
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
        if (Schema::hasTable('general_settings')){

            $general_settings = GeneralSetting::latest()->first();
            $isCrmModuleExist = File::exists(base_path('Modules/CRM'));

            view()->composer([
                'layout.main',
                'layout.main_partials.header',
                'layout.main_partials.sidebar',
                'layout.main_partials.footer',
                'projects.invoices.show',
                'dashboard',
                'layout.client',
                'frontend.Layout.navigation',
                'documentation.index',
                'vendor.translation.layout',
                'all_user.index',

                'vendor.translation.languages.create'
            ], function ($view) use ($general_settings, $isCrmModuleExist) {
                // $view->with('general_settings', $general_settings);
                $view->with(['general_settings'=>$general_settings, 'isCrmModuleExist'=> $isCrmModuleExist]);
            });
        }
    }
}



