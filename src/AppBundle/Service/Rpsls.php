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
     * @return string
     * @throws \ErrorException
     */
    public function getResult($userSelection, $computerSelection)
    {
        if (!array_key_exists($userSelection, $this->ruleSet)) {
            throw new \ErrorException("Invalid Selection: $userSelection");
        }

        if ($userSelection === $computerSelection) {
            return "tie";
        }

        try {
            if (array_key_exists($computerSelection, $this->ruleSet[$userSelection])) {
                return "win";
            }

            if (array_key_exists($userSelection, $this->ruleSet[$computerSelection])) {
                return "loss";
            }
        } catch (\Exception $e) {}

        throw new \ErrorException("Responses do no exist in rule set.");
    }
}