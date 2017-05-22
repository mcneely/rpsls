<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="history")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HistoryRepository")
 */
class History
{
    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $result;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     */
    private $userChoice;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     */
    private $computerChoice;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param int $result
     * @return History
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserChoice()
    {
        return $this->userChoice;
    }

    /**
     * @param string $userChoice
     * @return History
     */
    public function setUserChoice($userChoice)
    {
        $this->userChoice = $userChoice;
        return $this;
    }

    /**
     * @return string
     */
    public function getComputerChoice()
    {
        return $this->computerChoice;
    }

    /**
     * @param string $computerChoice
     * @return History
     */
    public function setComputerChoice($computerChoice)
    {
        $this->computerChoice = $computerChoice;
        return $this;
    }


}

