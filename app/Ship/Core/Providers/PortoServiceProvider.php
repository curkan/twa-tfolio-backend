<?php

declare(strict_types=1);

namespace App\Ship\Core\Providers;

use App\Ship\Core\Abstracts\Providers\MainServiceProvider as AbstractMainServiceProvider;
use App\Ship\Core\Foundation\Porto;
use App\Ship\Core\Loaders\AutoLoaderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

final class PortoServiceProvider extends AbstractMainServiceProvider
{
    use AutoLoaderTrait;
    // use ValidationTrait;

    public function register(): void
    {
        // NOTE: function order of this calls bellow are important. Do not change it.

        // $this->app->bind('Apiato', Apiato::class);
        // Register Core Facade Classes, should not be registered in the $aliases property, since they are used
        // by the auto-loading scripts, before the $aliases property is executed.
        // $this->app->alias(Apiato::class, 'Apiato');

        $this->app->bind('Porto', Porto::class);
        $this->app->alias(Porto::class, 'Porto');

        // parent::register() should be called AFTER we bind 'Apiato'
        parent::register();

        $this->runLoaderRegister();
    }

    public function boot(): void
    {
        parent::boot();
        $this->registerRequestMacros();
        $this->registerCustomValidateRule();
        $this->registerCollectionMacros();

        // Autoload most of the Containers and Ship Components
        $this->runLoadersBoot();

        // Solves the "specified key was too long" error, introduced in L5.4
        Schema::defaultStringLength(191);

        setlocale(LC_TIME, 'ru_RU.UTF-8');
        Carbon::setLocale(config('app.locale'));

        // Registering custom validation rules
        // $this->extendValidationRules();
    }

    private function registerRequestMacros(): void
    {
        Request::macro('inputAsInt', function (string $key, $default = null) {
            /**
             * @var Request $this
             */
            return $this->has($key) ? (int) $this->input($key) : $default;
        });

        Request::macro('inputAsBool', function (string $key, $default = null) {
            /**
             * @var Request $this
             */
            return $this->has($key) ? (bool) $this->input($key) : $default;
        });

        Request::macro('inputAsDate', function (string $key, $default = null) {
            /**
             * @var Request $this
             */
            return $this->has($key) ? Carbon::parse($this->input($key)) : $default;
        });
    }

    /**
     * @return void
     */
    private function registerCollectionMacros(): void
    {
        Collection::macro('recursive', function () {
            /**
             * @var Collection $this
             */
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });
    }

    /**
     * @return void
     */
    private function registerCustomValidateRule(): void
    {
        Validator::extend('lunique', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0]);
            $column = $query->getGrammar()->wrap($parameters[1]);

            return !$query->whereRaw("lower({$column}) = lower(?)", [$value])->count();
        });
    }
}
