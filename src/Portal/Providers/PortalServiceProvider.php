<?php namespace Portal\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PortalServiceProvider extends ServiceProvider {

    protected $configFiles = [
        'app.routes',
    ];

    protected $resourcesDirectory = '/../../../';


    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the config files
        $this->mergeConfigFiles();

        // Load the required routes
        $this->loadPackageRoutes();

        // Load the required Views
        $this->loadViewsFrom($this->getDirectory($this->resourcesDirectory, 'resources/views'), 'portal');

        // Load the required language files
        $this->loadTranslationsFrom($this->getDirectory($this->resourcesDirectory, 'resources/lang'), 'portal');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('Illuminate\Routing\Controller', 'IlluminateExtensions\Routing\Controller');


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
