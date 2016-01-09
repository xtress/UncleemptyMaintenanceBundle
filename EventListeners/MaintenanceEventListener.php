<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 12:26
 */

namespace Uncleempty\MaintenanceBundle\EventListeners;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
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

    private $isResponseHandled = false;

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

            $this->isResponseHandled = true;
            throw new MaintenanceException($this->params['denial']['response_message'], $this->params['denial']['response_code']);
        }
    }

    /**
     * Rewrites the http code of the response
     *
     * @param FilterResponseEvent $event FilterResponseEvent
     * @return void
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if ($this->isResponseHandled && $this->params['denial']['response_code'] !== null) {
            $response = $event->getResponse();
            $response->setStatusCode($this->params['denial']['response_code'], $this->params['denial']['response_message']);
        }
    }



}
