<?php

namespace Theme\Providers;

use Themosis\Facades\View;
use Themosis\Foundation\ServiceProvider;

class ViewComposerService extends ServiceProvider
{

	public function boot()
	{
		// eg ...
//		View::composer('modules.header', function ($view) {
//			$view->with('mainMenu', wp_nav_menu([
//				'menu' => 'main_menu'
//			]));
//		});
	}

	public function register()
	{

	}
}
