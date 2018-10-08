/** main application javascript file **/

import $ from "jquery";

// Utilities
import ModuleLoader from './utils/module-loader';

// Components - recurring elements for use in modules.

// Modules - sections on the website.
import Example from './modules/example';

// When document loads
$(document).ready(function () {
    $("a[href='#']").click(function (event) {
        event.preventDefault();
    });
    // load modules
    new ModuleLoader([
		Example,
    ]);
});

