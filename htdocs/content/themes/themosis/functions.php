<?php
/*
 * Themosis Theme.
 *
 * @author  Julien Lambé <julien@themosis.com>
 * @link 	http://www.themosis.com/
 */

/*----------------------------------------------------*/
// The directory separator.
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

if (!function_exists('themosis_theme_assets')) {
    /**
     * Return the application theme public assets directory URL.
     * Public assets are stored into the `dist` directory.
     *
     * @return string
     */
    function themosis_theme_assets()
    {
        if (is_multisite() && SUBDOMAIN_INSTALL) {
            $segments = explode('themes', get_template_directory_uri());
            $theme = (strpos($segments[1], DS) !== false) ? substr($segments[1], 1) : $segments[1];

            return get_home_url().'/'.CONTENT_DIR.'/themes/'.$theme.'/dist';
        }

        return get_template_directory_uri().'/dist';
    }
}

/*
 * Check if the framework is available.
 */
if (!isset($GLOBALS['themosis'])) {
    /*
     * Those strings are not translated.
     * We want to load only one textdomain for the theme with the domain
     * defined inside the theme.config.php file.
     */
    $text = 'The theme is only compatible with the Themosis framework. Please install the Themosis framework.';
    $title = 'WordPress - Missing framework';

    /*
     * Add a notice in the wp-admin.
     */
    add_action('admin_notices', function () use ($text) {
        printf('<div class="notice notice-warning is-dismissible"><p>%s</p></div>', $text);
    });

    /*
     * Add a notice in the front-end.
     */
    wp_die($text, $title);
}

/*
 * Retrieve the service container.
 */
$theme = container();

/*
 * Setup the theme paths.
 */
$paths['theme'] = __DIR__.DS;
$paths['theme.resources'] = __DIR__.DS.'resources'.DS;
$paths['theme.admin'] = __DIR__.DS.'resources'.DS.'admin'.DS;

themosis_set_paths($paths);

/*
 * Register all paths into the service container.
 */
$theme->registerAllPaths(themosis_path());

/*
 * Load theme configuration files.
 */
$theme['config.finder']->addPaths([
    themosis_path('theme.resources').'config'.DS,
]);

/*
 * Autoloading.
 */
$loader = new \Composer\Autoload\ClassLoader();
$classes = \Themosis\Facades\Config::get('loading');
foreach ($classes as $prefix => $path) {
    $loader->addPsr4($prefix, $path);
}
$loader->register();

/*
 * Register theme views folder path.
 */
$theme['view.finder']->addLocation(themosis_path('theme.resources').'views');

/*
 * Update Twig Loaded registered paths.
 */
$theme['twig.loader']->setPaths($theme['view.finder']->getPaths());

/*
 * Register theme public assets folder [dist directory].
 */
$theme['asset.finder']->addPaths([
    themosis_theme_assets() => themosis_path('theme').'dist',
]);

/*
 * Theme constants.
 */
$constants = new Themosis\Config\Constant($theme['config.factory']->get('constants'));
$constants->make();

/*
 * Register theme textdomain.
 */
defined('THEME_TEXTDOMAIN') ? THEME_TEXTDOMAIN : define('THEME_TEXTDOMAIN', $theme['config.factory']->get('theme.textdomain'));

$theme['action']->add('after_setup_theme', function () {
    load_theme_textdomain(THEME_TEXTDOMAIN, get_template_directory().'/languages');
});

/*
 * Theme aliases.
 */
$aliases = $theme['config.factory']->get('theme.aliases');

if (!empty($aliases) && is_array($aliases)) {
    foreach ($aliases as $alias => $fullname) {
        class_alias($fullname, $alias);
    }
}

/**
 * Register theme providers.
 */
$providers = $theme['config.factory']->get('providers');

foreach ($providers as $provider) {
    $theme->register($provider);
}

/*
 * Theme cleanup.
 */
if ($theme['config.factory']->get('theme.cleanup')) {
    $theme['action']->add('init', 'themosis_theme_cleanup');
}

/*
 * Theme restriction.
 */
$access = $theme['config.factory']->get('theme.access');

if (!empty($access) && is_array($access)) {
    $theme['action']->add('init', 'themosis_theme_restrict');
}

/*
 * Theme templates.
 */
$templates = new Themosis\Config\Template($theme['config.factory']->get('templates'), $theme['filter']);
$templates->make();

/*
 * Theme image sizes.
 */
$images = new Themosis\Config\Images($theme['config.factory']->get('images'), $theme['filter']);
$images->make();

/*
 * Theme menus.
 */
$menus = new Themosis\Config\Menu($theme['config.factory']->get('menus'));
$menus->make();

/*
 * Theme sidebars.
 */
$sidebars = new Themosis\Config\Sidebar($theme['config.factory']->get('sidebars'));
$sidebars->make();

/*
 * Theme supports.
 */
$supports = new Themosis\Config\Support($theme['config.factory']->get('supports'));
$supports->make();

/*
 * Theme admin files.
 * Autoload files in alphabetical order.
 */
$loader = $theme['loader']->add([
    themosis_path('theme.admin'),
]);

$loader->load();

/*
 * Theme widgets.
 */
$widgetLoader = $theme['loader.widget']->add([
    themosis_path('theme.resources').'widgets'.DS,
]);

$widgetLoader->load();

/*
 * Theme global JS object.
 */
$theme['action']->add('wp_head', 'themosis_theme_global_object');

/**
 * Stop editing. Happy development.
 */
function themosis_theme_cleanup()
{
    global $wp_widget_factory;

    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    if (array_key_exists('WP_Widget_Recent_Comments', $wp_widget_factory->widgets)) {
        remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
    }

    add_filter('use_default_gallery_style', '__return_null');
}

/**
 * Callback used to restrict wp-admin access to
 * logged-in users only. Non authenticated users will
 * be redirected to the home page.
 */
function themosis_theme_restrict()
{
    $access = Themosis\Facades\Config::get('theme.access');

    if (is_admin()) {
        $user = wp_get_current_user();
        $role = $user->roles;
        $valid_role = (bool) array_intersect($access, $role);

        if (!$valid_role && !(defined('DOING_AJAX') && DOING_AJAX)  && !(defined('WP_CLI') && WP_CLI)) {
            wp_redirect(home_url());
            exit;
        }
    }
}

/**
 * Callback used to implement a JS global object
 * for your scripts. Complement the asset localize API.
 */
function themosis_theme_global_object()
{
    $namespace = Themosis\Facades\Config::get('theme.namespace');
    $url = admin_url().Themosis\Facades\Config::get('theme.ajaxurl').'.php';

    $datas = apply_filters('themosisGlobalObject', []);

    $output = "<script type=\"text/javascript\">\n\r";
    $output .= "//<![CDATA[\n\r";
    $output .= 'var '.$namespace." = {\n\r";
    $output .= "ajaxurl: '".$url."',\n\r";

    if (!empty($datas)) {
        foreach ($datas as $key => $value) {
            $output .= $key.': '.json_encode($value).",\n\r";
        }
    }

    $output .= "};\n\r";
    $output .= "//]]>\n\r";
    $output .= '</script>';

    // Output the datas.
    echo $output;
}
