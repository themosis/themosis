<?php
/**
 * Created by PhpStorm.
 * User: danfulcher
 * Date: 20/09/2018
 * Time: 14:24
 */

namespace Theme\Controllers;

use Themosis\Route\BaseController;

class PageController extends BaseController {

	/**
	 * @return string
	 */
	public function home() {
		return view( 'home', [
			'exampleText' => 'themosis-boilerplate',
		] );
	}

	/**
	 * @return string
	 */
	public function show()
	{
		return view('templates.default', ['fields' => get_fields()]);
	}

	/**
	 * @return string
	 */
	public function notFound()
	{
		return view('404');
	}

}
