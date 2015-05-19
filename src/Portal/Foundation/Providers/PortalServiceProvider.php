<?php namespace Portal\Foundation\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Portal\Companies\Contracts\CompaniesRepository;
use Portal\Companies\Contracts\EloquentCompaniesRepository;
use Portal\Companies\Models\Company;
use Portal\Scripts\Contracts\ReportRepository;
use Portal\Scripts\Repositories\Report\OldEloquentReportRepository;
use Portal\Scripts\Repositories\Report\OldTransformReportRepository;
use Portal\Users\Contracts\UserRepository;
use Portal\Users\Repositories\User\OldEloquentUserRepository;
use Portal\Users\Repositories\User\OldTransformUserRepository;

class PortalServiceProvider extends ServiceProvider {

    protected $configFiles = [
        'app.routes',
    ];

    protected $resourcesDirectory = '/../../../../';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Load the config files
        $this->mergeConfigFiles();

        // Load the required routes
        $this->loadPackageRoutes();

        // Publish the migrations
        $this->publishes([
            $this->getDirectory($this->resourcesDirectory, 'resources/migrations') => database_path('/migrations')
        ], 'migrations');

        // Load the required Views
        $this->loadViewsFrom($this->getDirectory($this->resourcesDirectory, 'resources/views'), 'portal');

        // Load the required language files
        $this->loadTranslationsFrom($this->getDirectory($this->resourcesDirectory, 'resources/lang'), 'portal');

        $this->bindRouting($router);

    }

    private function bindRouting(Router $router)
    {
        $router->bind('company', function($company) {
            return Company::with(['addresses','numbers','extracontactdetails', 'orders', 'orders.details', 'activity'])->whereSlug($company)->firstOrFail();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindUsers();
        $this->bindSurveys();
        $this->bindCompanies();
    }


    protected function bindUsers()
    {
        $this->app->bind(UserRepository::class, function() {
            $user = new OldEloquentUserRepository();
            $user = new OldTransformUserRepository($user);

            return $user;
        });
    }

    protected function bindSurveys()
    {
        $this->app->bind(['survey', ReportRepository::class], function() {
            $report = new OldEloquentReportRepository();
            $report = new OldTransformReportRepository($report);

            //$report = new CachedReportRepository($report, $this->app['cache.store']);

            return $report;
        });
    }

    protected function bindCompanies()
    {
        $this->app->bind(['company', CompaniesRepository::class], function(){
            return new EloquentCompaniesRepository();
        });
    }




    /**
     * @param null $source
     * @param null $item
     * @return string
     */
    private function getDirectory($source = null, $item = null)
    {
        // Generate the requested directory
        return __DIR__ . $source . $item;
    }


    /**
     * @return array
     */
    private function mergeConfigFiles()
    {
        // Store all the merged config files
        $mergedConfigFiles = [];

        // Merge all config files added to the class array
        foreach ($this->configFiles as $configFile)
        {
            // Find the real file name
            $fileName = $this->getDirectory($this->resourcesDirectory, 'resources/configs/' . str_replace('.', '/', $configFile) . '.php');

            // If the config file exists then merge in, otherwise log as an error
            if (file_exists($fileName))
            {
                $this->mergeConfigFrom($fileName, 'portal.'.$configFile);
                $mergedConfigFiles[] = $configFile;
            } else {
                \Log::error("Couldn't merge config file.", [
                    'package' => 'portal/framework',
                    'configFile' => $configFile
                ]);
            }
        }

        return $mergedConfigFiles;
    }

    /**
     * @return array
     */
    private function loadPackageRoutes()
    {
        // Store all the loaded route files
        $loadedRouteFiles = [];

        // Load all route files from the config file
        foreach (config('portal.app.routes.load') as $routeFile)
        {
            // Find the real file name
            $fileName = $this->getDirectory($this->resourcesDirectory, 'resources/routes/'.str_replace('.', '/', $routeFile).'.php');

            // If the route file exists then merge in, otherwise log as an error
            if (file_exists($fileName))
            {
                include $fileName;
                $loadedRouteFiles[] = $loadedRouteFiles;
            } else {
                \Log::error("Couldn't load route file.", [
                    'package' => 'portal/framework',
                    'routeFile' => $routeFile
                ]);
            }

        }

        return $loadedRouteFiles;
    }
}
