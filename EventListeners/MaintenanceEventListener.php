<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 12:26
 */

namespace Uncleempty\MaintenanceBundle\EventListeners;
use Uncleempty\MaintenanceBundle\Exceptions\MaintenanceException;


/**
 * Listener to decide if user can access to the web-app
 *
 * @package UncleemptyMaintenanceBundle
 * @author  Ilya Yarkovets <yarkovets.i@gmail.com>
 */
class MaintenanceEventListener
{
    /** @var array $params */
    private $params;

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param $config
     */
    public function setConfig($config)
    {
        $this->params = $config;
    }

    /**
     * @throws MaintenanceException
     */
    public function onKernelRequest()
    {
        if ($this->params['enabled']) {

            if (is_array($this->params['allowance']['ips']) && !empty($this->params['allowance']['ips'])) {

            }

            if ($this->params['allowance']['path'] !== null) {

            }

            throw new MaintenanceException($this->params['denial']['response_message'], $this->params['denial']['response_code']);
        }
    }



}
