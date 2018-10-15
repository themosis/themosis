<?php
/**
 * Created by PhpStorm.
 * User: danfulcher
 * Date: 20/09/2018
 * Time: 14:24
 */

namespace Theme\Controllers;

use Theme\Models\Example;
use Themosis\Route\BaseController;

class ExampleController extends BaseController {

	/**
 * @return string
 */
	public function index() {
		return view( 'archive.example', [
			'exampleItems' => Example::published()->menuOrder()->get(),
		] );
	}

	/**
	 * @return string
	 */
	public function show($example) {

		return view( 'single.example', [
			'fields' => get_fields(),
		] );
	}

}
