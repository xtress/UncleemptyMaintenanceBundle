<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 12:26
 */

namespace Uncleempty\MaintenanceBundle\EventListeners;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
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
     * @param $config
     */
    public function setConfig($config)
    {
        $this->params = $config;
    }

    /**
     * @param GetResponseEvent $event
     * @return bool
     *
     * @throws MaintenanceException
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($this->params['enabled']) {

            if (is_array($this->params['allowance']['ips']) && !empty($this->params['allowance']['ips'])) {
                if ($this->checkClientIp($request->getClientIp(), $this->params['allowance']['ips'])) {
                    return true;
                }
            }

            if (
                $this->params['allowance']['path'] !== null
                && !empty($this->params['allowance']['path'])
                && preg_match('{'.$this->params['allowance']['path'].'}', rawurldecode($request->getPathInfo()))
            ) {
                return true;
            }

            if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
                $this->isResponseHandled = true;
                throw new MaintenanceException($this->params['denial']['response_message'], $this->params['denial']['response_code']);
            }
        } else {
            return true;
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

    public function checkClientIp($clientIp, array $allowedIps = array())
    {
        if (count($allowedIps) > 0) {
            return in_array($clientIp, $allowedIps);
        } else {
            return false;
        }
    }



}
