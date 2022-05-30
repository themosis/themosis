<?php

class LocalValetDriver extends LaravelValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     *
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        return file_exists($sitePath.'/htdocs/cms/wp-load.php');
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     *
     * @return false|string
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        $staticFilePath = $sitePath.'/htdocs'.$uri;

        if ($this->isActualFile($staticFilePath)) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     *
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        $_SERVER['PHP_SELF'] = $uri;
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];

        if (strpos($uri, '/cms/') === 0) {
            if (is_dir($sitePath.'/htdocs'.$uri)) {
                $uri = $this->forceTrailingSlash($uri);

                return $sitePath.'/htdocs'.$uri.'/index.php';
            }

            return $sitePath.'/htdocs'.$uri;
        }

        return $sitePath.'/htdocs/index.php';
    }

    /**
     * Redirect to uri with trailing slash.
     *
     * @param  string $uri
     *
     * @return string
     */
    private function forceTrailingSlash($uri)
    {
        if (substr($uri, -1 * strlen('/cms/wp-admin')) == '/cms/wp-admin') {
            header('Location: '.$uri.'/');
            die;
        }

        return $uri;
    }
}
