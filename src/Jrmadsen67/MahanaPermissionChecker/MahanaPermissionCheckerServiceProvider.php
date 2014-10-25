<?php namespace Jrmadsen67\MahanaPermissionChecker;

use Illuminate\Support\ServiceProvider;

class MahanaPermissionCheckerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('jrmadsen67/mahana-permission-checker');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

        $this->app['mahana_permission_checker'] = function () {
            return new \Jrmadsen67\MahanaPermissionChecker\MahanaPermissionChecker(
                new \Jrmadsen67\MahanaPermissionChecker\repositories\PermissionCheckerEloquentRepository
            );
        };

		$this->app->bind('Jrmadsen67\MahanaPermissionChecker\repositories\PermissionCheckerRepositoryInterface', 
			'Jrmadsen67\MahanaPermissionChecker\repositories\PermissionCheckerEloquentRepository');

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('mahana-hierarchy-laravel');
	}

}
