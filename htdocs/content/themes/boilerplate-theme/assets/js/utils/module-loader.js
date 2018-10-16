import $ from 'jquery';
import {camelToKebab} from "./camel-to-kebab";

class ModuleLoader {

	/**
	 * @param modules
	 */
	constructor(modules) {

		this.modules = modules;
		this.loadModules();
	}

	/**
	 * Load an instance of the module class for each
	 * element on the page and fire the init function
	 */
	loadModules() {
		this.modules.forEach(function (module) {
			// IE fallback for module.name
			let name = module.name ? module.name : module.toString().match(/^function\s*([^\s(]+)/)[1];
			let elements = $('[data-js-' + camelToKebab(name) + ']');
			if (elements.length > 0) {
				elements.each(function () {
					let instance = new module($(this));
					instance.init();
				})
			}
		})
	}

}

export default ModuleLoader;
