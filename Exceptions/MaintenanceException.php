<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 15:00
 */

namespace Uncleempty\MaintenanceBundle\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class MaintenanceException extends HttpException
{

    public function __construct($message, $code)
    {
        parent::__construct($code, $message, null, null, $code);
    }

}
