<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */
    'name' => env('APP_NAME', 'Themosis'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */
    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    */
    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | WordPress URL
    |--------------------------------------------------------------------------
    |
    */
    'wp' => env('WP_URL', 'http://localhost/cms'),

    /*
    |--------------------------------------------------------------------------
    | Charset Encoding
    |--------------------------------------------------------------------------
    |
    */
    'charset' => env('APP_CHARSET', 'UTF-8'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider coming from the Illuminate package, not
    | directly the WordPress behavior.
    |
    */
    'locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    | Some plugins may also extend the list of service providers directly.
    |
    */
    'providers' => [
        // Illuminate + Themosis providers
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Themosis\Core\Providers\ConsoleCoreServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Themosis\Asset\AssetServiceProvider::class,
        Themosis\Core\Providers\CoreServiceProvider::class,
        Themosis\Html\HtmlServiceProvider::class,
        Themosis\Hook\HookServiceProvider::class,
        Themosis\Field\FieldServiceProvider::class,
        Themosis\Forms\FormServiceProvider::class,
        Themosis\Metabox\MetaboxServiceProvider::class,
        Themosis\Page\PageServiceProvider::class,

        // Application providers
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\RouteServiceProvider::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Application hooks
    |--------------------------------------------------------------------------
    |
    | This array of hookable classes will be triggered when the WordPress
    | hook API is loaded. Feel free to register as many hookable classes
    | as you wish in order to organize your code.
    |
    */
    'hooks' => [
        App\Hooks\Application::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */
    'aliases' => [
        'Action' => Themosis\Support\Facades\Action::class,
        'App' => Illuminate\Support\Facades\App::class,
        'Asset' => Themosis\Support\Facades\Asset::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Console' => Themosis\Core\Support\Facades\Console::class,
        'Field' => Themosis\Support\Facades\Field::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Form' => Themosis\Support\Facades\Form::class,
        'Filter' => Themosis\Support\Facades\Filter::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Html' => Themosis\Support\Facades\Html::class,
        'Metabox' => Themosis\Support\Facades\Metabox::class,
        'Page' => Themosis\Support\Facades\Page::class,
        'Route' => Themosis\Support\Facades\Route::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class
    ],

    /*
    |--------------------------------------------------------------------------
    | WordPress Conditions
    |--------------------------------------------------------------------------
    |
    | This array of conditions is used by the router to detect any WordPress
    | request. The key is the WordPress conditional function signature and
    | the value is a string or an array of matching conditions for the route.
    |
    */
    'conditions' => [
        'is_404' => '404',
        'is_archive' => 'archive',
        'is_attachment' => 'attachment',
        'is_author' => 'author',
        'is_category' => ['category', 'cat'],
        'is_date' => 'date',
        'is_day' => 'day',
        'is_front_page' => ['/', 'front'],
        'is_home' => ['home', 'blog'],
        'is_month' => 'month',
        'is_page' => 'page',
        'is_paged' => 'paged',
        'is_page_template' => 'template',
        'is_post_type_archive' => ['post-type-archive', 'postTypeArchive'],
        'is_search' => 'search',
        'is_single' => 'single',
        'is_singular' => 'singular',
        'is_sticky' => 'sticky',
        'is_tag' => 'tag',
        'is_tax' => 'tax',
        'is_time' => 'time',
        'is_year' => 'year'
    ]
];
