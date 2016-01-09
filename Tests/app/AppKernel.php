<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 09.01.16
 * Time: 20:39
 */

namespace Uncleempty\MaintenanceBundle\Tests\app;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles()
    {
        $bundles = array(
            //Указываем какие бандлы нам необходимы
        );

        return $bundles;
    }

    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}