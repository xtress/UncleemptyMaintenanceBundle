<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 12:26
 */

namespace Uncleempty\MaintenanceBundle\EventListeners;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * Listener to decide if user can access to the web-app
 *
 * @package UncleemptyMaintenanceBundle
 * @author  Ilya Yarkovets <yarkovets.i@gmail.com>
 */
class MaintenanceEventListener
{
    /** @var HttpKernelInterface $httpKernel */
    private $httpKernel;

    /** @var RequestStack $requestStack */
    private $requestStack;

    /** @var boolean $debug */
    private $debug;

    /** @var array $params */
    private $params;

    /**
     * @param ContainerInterface $container
     *
     * @param $debug
     */
    public function __construct(ContainerInterface $container)
    {
        $this->httpKernel   = $container->get('http_kernel');
        $this->requestStack = $container->get('request_stack');
        $this->debug        = $container->getParameter('kernel.debug');
    }

    /**
     * @param $config
     */
    public function setConfig($config)
    {
        $this->params = $config;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($this->params['enabled']) {

            $request = $event->getRequest();

            if (is_array($this->params['allowance']['ips'])) {

            }

            if ($this->params['allowance']['path'] !== null) {

            }

            $this->forward(
                'UncleemptyMaintenanceBundle:MaintenanceController:maintenanceAction',
                [

                ],
                [
                    'message' => $this->params['denial']['message']
                ]
            );
        }
    }

    private function forward($controller, array $path = array(), array $query = array())
    {
        $path['_controller'] = $controller;
        $subRequest = $this->requestStack->getCurrentRequest()->duplicate(null, $query, $path);

        return $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }



}