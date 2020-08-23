<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('xml_check', function ($attribute, $value, $parameters, $validator) {
            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadXML($value);
            $errors = libxml_get_errors();
            if (empty($errors)) {
                return true;
            }
            else
                return false;
        });
    }
}
