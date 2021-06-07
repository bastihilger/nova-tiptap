<?php

namespace Manogi\Tiptap;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Nova::provideToScript([
            'novaTiptap' => [
                'translations' => $this->translations()
            ]
        ]);
        
        Nova::serving(function (ServingNova $event) {
            Nova::script('tiptap', __DIR__.'/../dist/js/field.js');
            Nova::style('tiptap', __DIR__.'/../dist/css/field.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function translations()
    {
        $file = resource_path('lang/vendor/nova-tiptap/'.app()->getLocale().'.json');

        if (!is_readable($file)) {
            $file = base_path('vendor/manogi/nova-tiptap/resources/lang/'.app()->getLocale().'.json');
        }

        if (is_readable($file)) {
            $json = json_decode(file_get_contents($file));
            return is_object($json) ? $json : [];
        }

        return [];
    }
}
