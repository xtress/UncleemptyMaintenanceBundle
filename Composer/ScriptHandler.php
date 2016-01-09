<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 15:53
 */

namespace Uncleempty\MaintenanceBundle\Composer;

class ScriptHandler
{
    const MAINTENANCE_ERROR_VIEW_PATH = 'app/Resources/TwigBundle/views/Exception';
    const EXTENSION_ERROR_VIEW_PATH   = 'vendor/uncleempty/maintenance-bundle/Uncleempty/MaintenanceBundle/Resources/views';

    const MAINTENANCE_VIEW_NAME = 'error503.html.twig';

    public static function placeErrorView()
    {
        if (!is_file(self::MAINTENANCE_ERROR_VIEW_PATH.'/'.self::MAINTENANCE_VIEW_NAME)) {
            if (!is_dir(self::MAINTENANCE_ERROR_VIEW_PATH)) {
                static::createDir(self::MAINTENANCE_ERROR_VIEW_PATH);
            }
            copy(self::EXTENSION_ERROR_VIEW_PATH.'/'.self::MAINTENANCE_VIEW_NAME, self::MAINTENANCE_ERROR_VIEW_PATH.'/');
        }
    }

    private static function createDir($path)
    {
        mkdir($path, 0755, true);
    }
}
