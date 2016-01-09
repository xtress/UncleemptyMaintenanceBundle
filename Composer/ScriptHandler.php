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
    const MAINTENANCE_ERROR_VIEW_PATH = 'app/Resources/TwigBundle/views/Exception/error503.html.twig';
    const EXTENSION_ERROR_VIEW_PATH   = 'vendor/uncleempty/maintenance-bundle/Uncleempty/MaintenanceBundle/Resources/views/error503.html.twig';

    public static function placeErrorView()
    {
        if (!is_file(self::MAINTENANCE_ERROR_VIEW_PATH)) {
            copy(self::EXTENSION_ERROR_VIEW_PATH, self::MAINTENANCE_ERROR_VIEW_PATH);
        }
    }
}
