<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Route("/select/{user}", name="select")
     * @Template()
     * @param string|bool $user
     * @return array
     */
    public function indexAction($user = false)
    {
        /** @var \AppBundle\Service\Rpsls $rpslsService*/
        $rpslsService = $this->get('service_rpsls');
        /** @var \AppBundle\Service\Statistics $statisticsService */
        $statisticsService = $this->get('service_statistics');

        $ruleSet      = $this->getParameter("ruleset");
        $computer     = $rpslsService->getRandom();
        $result       = false;

        if ($user) {

            $result = $rpslsService->getResult($user, $computer);
            $statisticsService->addResult($user, $computer, $result);
        }

        return [
            'computer' => $computer,
            'user'     => $user,
            'result'   => $result,
            'ruleset'  => $ruleSet
        ];
    }

    /**
     * @Route("/stats", name="stats")
     * @Route("/stats/clear/{clear}", name="clear")
     * @Template()
     * @return array
     */
    public function statsAction($clear = false)
    {
        /** @var \AppBundle\Service\Statistics $statisticsService */
        $statisticsService = $this->get('service_statistics');
        if($clear) {
            $statisticsService->clearStats();
        }
        $statisticsService->buildStats();
        return ['stats' => $statisticsService];
    }

}
