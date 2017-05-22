<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Service\Rpsls;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class RpslsServiceTest extends TestCase
{
    /** @var  array $ruleSet */
    protected $ruleSet;
    /** @var  Rpsls $class */
    protected $class;

    public function setUp()
    {
        $this->ruleSet = [
            'rock'     => [
                'scissors' => 'crushes'
            ],
            'paper'    => [
                'rock'  => 'covers'
            ],
            'scissors' => [
                'paper'  => 'cuts'
            ]
        ];

        $this->class = new Rpsls($this->ruleSet);
    }

    public function testGetRandom() {
        $this->assertTrue(array_key_exists($this->class->getRandom(), $this->ruleSet));
    }

    public function testGetResult() {
        $this->assertEquals("tie", $this->class->getResult("rock", "rock"));
        $this->assertEquals("win", $this->class->getResult("paper", "rock"));
        $this->assertEquals("loss", $this->class->getResult("paper", "scissors"));
    }
}
