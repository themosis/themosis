<?php
if (!function_exists("theme_path")) {
    /**
     * Resolve to full path prefix with `$name` defined via `themosis_set_paths`
     *
     * @param string $name
     * @param string $path
     * @return void
     */
    function theme_path(string $name, string $path)
    {
        return realpath(themosis_path($name) . "/" . $path);
    }
}
