<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @Route("/{user}", name="home")
     * @Template()
     * @param string|bool $user
     * @return array
     */
    public function indexAction($user = false)
    {
        /** @var $rpslsService \AppBundle\Service\Rpsls */
        $rpslsService = $this->get('service_rpsls');
        $ruleSet      = $this->getParameter("ruleset");
        $computer     = $rpslsService->getRandom();
        $result       = false;

        if ($user) {
            $result = $rpslsService->getResult($user, $computer);
        }

        return [
            'computer' => $computer,
            'user'     => $user,
            'result'   => $result,
            'ruleset'  => $ruleSet
        ];
    }
}
