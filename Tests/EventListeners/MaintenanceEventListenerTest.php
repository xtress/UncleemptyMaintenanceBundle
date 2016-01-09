<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 19:29
 */

namespace Uncleempty\MaintenanceBundle\Tests\EventListeners;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Uncleempty\MaintenanceBundle\EventListeners\MaintenanceEventListener;
use Uncleempty\MaintenanceBundle\Exceptions\MaintenanceException;

class MaintenanceEventListenerTest extends WebTestCase
{
    public function setUp() {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
    }

    public function testServiceLoaded()
    {
        $this->assertEquals(
            get_class(
                $this->container->get('uncleempty_maintenance.listener')
            ),
            $this->container->getParameter('uncleempty_maintenance.listener.class')
        );
    }

    public function testSiteNotOnMaintenance()
    {
        $config = [
            'enabled'   => false,
            'allowance' => [
                'path' => '/news',
                'ips'  => []
            ],
            'denial'    => [
                'response_code'                 => 503,
                'response_message'              => 'Service is temporarily on maintenance!'
            ],
        ];

        $this->bootKernel();

        $listener = new MaintenanceEventListener();
        $listener->setConfig($config);

        $this->client->request('POST', '/cargos');
        $request = $this->client->getRequest();

        $event = new GetResponseEvent(self::$kernel, $request, HttpKernelInterface::MASTER_REQUEST);

        $this->assertEquals($listener->onKernelRequest($event), true);

    }

    public function testSiteOnMaintenanceAllowedFromLocalhost()
    {
        $config = [
            'enabled'   => true,
            'allowance' => [
                'path' => '/news',
                'ips'  => ['127.0.0.1']
            ],
            'denial'    => [
                'response_code'                 => 503,
                'response_message'              => 'Service is temporarily on maintenance!'
            ],
        ];

        $this->bootKernel();

        $listener = new MaintenanceEventListener();
        $listener->setConfig($config);

        $this->client->request('POST', '/cargos');
        $request = $this->client->getRequest();

        $event = new GetResponseEvent(self::$kernel, $request, HttpKernelInterface::MASTER_REQUEST);

        $this->assertEquals($listener->onKernelRequest($event), true);
    }

    public function testSiteOnMaintenanceAllowedRoute()
    {
        $config = [
            'enabled'   => true,
            'allowance' => [
                'path' => '/news',
                'ips'  => []
            ],
            'denial'    => [
                'response_code'                 => 503,
                'response_message'              => 'Service is temporarily on maintenance!'
            ],
        ];

        $this->bootKernel();

        $listener = new MaintenanceEventListener();
        $listener->setConfig($config);

        $this->client->request('POST', '/news/list');
        $request = $this->client->getRequest();

        $event = new GetResponseEvent(self::$kernel, $request, HttpKernelInterface::MASTER_REQUEST);

        $this->assertEquals($listener->onKernelRequest($event), true);
    }

    public function testSiteFullyOnMaintenance()
    {
        $config = [
            'enabled'   => true,
            'allowance' => [
                'path' => null,
                'ips'  => []
            ],
            'denial'    => [
                'response_code'                 => 503,
                'response_message'              => 'Service is temporarily on maintenance!'
            ],
        ];

        $this->bootKernel();

        $listener = new MaintenanceEventListener();
        $listener->setConfig($config);

        $this->client->request('POST', '/news/list');
        $request = $this->client->getRequest();

        try {
            $event = new GetResponseEvent(self::$kernel, $request, HttpKernelInterface::MASTER_REQUEST);

            $listener->onKernelRequest($event);
        } catch (\Exception $e) {
            $this->assertEquals(get_class($e), get_class(new MaintenanceException('dummy message', 503)));
        }
    }
}
