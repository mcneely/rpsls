<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcneely
 * Date: 5/21/17
 * Time: 4:51 PM
 */

namespace AppBundle\Service;

class Rpsls
{
    const WIN  = 1;
    const LOSS = 2;
    const TIE  = 3;

    private $ruleSet = [];

    public function __construct(array $ruleSet)
    {
        /*
         * I currently only need the ruleset so there's no need
         * to inject whole container at this point.
         */
        $this->ruleSet = $ruleSet;
    }

    /**
     * @return string
     */
    public function getRandom()
    {
        return array_rand($this->ruleSet);
    }

    /**
     * @param $userSelection
     * @param $computerSelection
     * @return integer
     * @throws \ErrorException
     */
    public function getResult($userSelection, $computerSelection)
    {
        if (!array_key_exists($userSelection, $this->ruleSet)) {
            throw new \ErrorException("Invalid Selection: $userSelection");
        }

        if ($userSelection === $computerSelection) {
            return $this::TIE;
        }

        try {
            if (array_key_exists($computerSelection, $this->ruleSet[$userSelection])) {
                return $this::WIN;
            }

            if (array_key_exists($userSelection, $this->ruleSet[$computerSelection])) {
                return $this::LOSS;
            }
        } catch (\Exception $e) {
        }

        throw new \ErrorException("Responses do no exist in rule set.");
    }
}
