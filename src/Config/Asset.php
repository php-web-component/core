<?php namespace PWC\Config;

use PWC\Singleton\Config;

class Asset extends Config
{
    protected $dir;

    public function __setDefaultValue()
    {
        if (!is_null(Application::get('rootDir'))) {
            $composerJsonFile = Application::get('rootDir') . '/composer.json';
            $composer = json_decode(file_get_contents($composerJsonFile));
            if (isset($composer->extra->pwc->assets->dir)) {
                self::set('dir', Application::get('baseUrl') .  '/' . $composer->extra->pwc->assets->dir . '/');
            }
        }
    }
}
