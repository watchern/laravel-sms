<?php

/*
 * This file is part of charles/laravel-sms.
 *
 * (c) Charles <https://www.charles.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\Sms;

use Charles\Sms\Storage\CacheStorage;
use Illuminate\Support\Facades\Route;
use Overtrue\EasySms\EasySms;
use Charles\Sms\Http\Middleware\ThrottleRequests;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * @var string
	 */
	protected $namespace = 'Charles\Sms';

	/**
	 * Boot the service provider.
	 */
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../config/config.php' => config_path('charles/sms.php'),
			]);

			$this->loadMigrationsFrom(__DIR__ . '/../migrations');
		}

		if (!$this->app->routesAreCached()) {
			$routeAttr = config('charles.sms.route', []);
			if (config('charles.sms.enable_rate_limit')) {
				$routeAttr['middleware'] = array_merge($routeAttr['middleware'], [config('charles.sms.rate_limit_middleware') . ':' . config('charles.sms.rate_limit_count') . ',' . config('charles.sms.rate_limit_time')]);
			}

			Route::group(array_merge(['namespace' => $this->namespace], $routeAttr), function ($router) {
				require __DIR__ . '/route.php';
			});
		}
	}

	/**
	 * Register the service provider.
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__ . '/../config/config.php', 'charles.sms'
		);

		$this->app->singleton(Sms::class, function ($app) {
			$storage = config('charles.sms.storage', CacheStorage::class);

			return new Sms(new EasySms(config('charles.sms.easy_sms')), new $storage());
		});
	}

	/**
	 * @return array
	 */
	public function provides()
	{
		return [Sms::class];
	}
}
