<?php

namespace Uncleempty\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/maintenance")
 */
class MaintenanceController extends Controller
{
    /**
     * @Route("/", name="maintenance_index")
     * @Template()
     */
    public function maintenanceAction(Request $request)
    {
        $params = $request->request->all();

        $message = $params['message'];

        return ['message' => $message];
    }

}
