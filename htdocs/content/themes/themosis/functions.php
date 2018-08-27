<?php

$app = app();

add_action('template_redirect', function () use ($app) {
    require $app->themesPath('themosis/routes.php');
});
