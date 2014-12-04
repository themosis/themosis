<?php

/*----------------------------------------------------*/
// Define your environments
/*----------------------------------------------------*/
return function()
{
    return ('apache_local' === getenv('APP_ENV')) ? 'local': 'production';
};