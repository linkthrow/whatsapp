<?php namespace LinkThrow\Whatsapp\Providers;

use App;
use Config;
use Event;
use File;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use MGP25WhatapiEvents;
use WhatsProt;
use LinkThrow\Whatsapp\Clients\WhatsappMGP25Client;

class WhatsappServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    public function boot()
    {
        $loader  = AliasLoader::getInstance();
        $aliases = Config::get('app.aliases');
        if (empty($aliases['WhatsApp']))
        {
            $loader->alias('WhatsApp', 'LinkThrow\Whatsapp\Facades\WhatsappFacade');
        }

        $this->publishes([
            realpath(__DIR__.'/../config/whatsapp.php') => config_path('whatsapp.php'),
        ]);

        $config = $this->app['config']['whatsapp'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['whatsapp'] = $this->app->share(function($app)
        {
            return new Whatsapp;
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('whatsapp');
    }

}
