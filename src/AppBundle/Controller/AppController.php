<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        /** @var $rpslsService \AppBundle\Service\Rpsls */
        $rpslsService = $this->get('service_rpsls');
        $ruleSet      = $this->getParameter("ruleset");
        $user         = $rpslsService->getRandom();
        $computer     = $rpslsService->getRandom();
        $result       = $rpslsService->getResult($user, $computer);
        // replace this example code with whatever you need
        return [
            'computer' => $computer,
            'user'     => $user,
            'result'   => $result,
            'ruleset'  => $ruleSet
        ];
    }
}
