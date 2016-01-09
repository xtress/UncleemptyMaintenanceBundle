<?php

namespace Uncleempty\MaintenanceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DummyController extends Controller
{
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/closed/dummy", name="closed-dummy")
     */
    public function indexClosedAction()
    {

    }
}
