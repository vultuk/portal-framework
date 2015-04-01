<?php namespace Portal\Providers;

use Illuminate\Support\ServiceProvider;

class PortalServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        dd(__DIR__);

        $this->loadViewsFrom(__DIR__.'/path/to/views', 'portal');

        $this->loadTranslationsFrom(__DIR__.'/path/to/translations', 'courier');

        include __DIR__.'/../../resources/routes/ticket.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}