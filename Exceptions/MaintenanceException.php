<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 15:00
 */

namespace Uncleempty\MaintenanceBundle\Exceptions;


class MaintenanceException extends \Exception
{

    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }

}
