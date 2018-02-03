<?php namespace Weidacat\Ldap;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Weidacat\Ldap\Providers\LdapAuthUserProvider;

class LdapServiceProvider extends ServiceProvider {

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
		$this->publishes([
            __DIR__ . '/config/ldap.php' => config_path('ldap.php'),
        ]);

		Auth::provider('ldap', function ($app, array $config) {
			return new LdapAuthUserProvider($app['hash'], $config['model']);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('ldap', function ($app) {
            $config = $app['config']->get('ldap');
            return new LdapManager($config);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('ldap');
	}

}
