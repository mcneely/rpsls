<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcneely
 * Date: 5/21/17
 * Time: 11:27 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\History;

class Statistics
{
    /** @var  \Doctrine\ORM\EntityManager $entityManager */
    private $entityManager;
    /** @var \Doctrine\ORM\QueryBuilder */
    private $queryBuilder;
    /** @var  integer $totalGames */
    private $totalGames = 0;
    /** @var  integer $userWins */
    private $userWins = 0;
    /** @var  $userAnswers */
    private $userAnswers = [];
    /** @var  integer $computerWins */
    private $computerWins = 0;
    /** @var  array $computerAnswers */
    private $computerAnswers = [];
    /** @var integer $tieGames */
    private $tieGames = 0;

    /**
     * Statistics constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->queryBuilder  = $entityManager
            ->createQueryBuilder()
            ->from('AppBundle:History', 'h');
    }

    public function addResult($userChoice, $computerChoice, $result)
    {
        $history = new History();
        $history
            ->setComputerChoice($computerChoice)
            ->setUserChoice($userChoice)
            ->setResult($result);

        $this->entityManager->persist($history);
        $this->entityManager->flush();
    }

    public function buildStats()
    {
        $this->buildWins();
        $this->buildCounts();
        $this->setTotalGames(
            $this->getComputerWins()
            + $this->getUserWins()
            + $this->getTieGames()
        );

    }

    private function buildWins()
    {
        $this->queryBuilder
            ->select("h.result, COUNT(h.id) as cnt")
            ->where('h.result IS NOT NULL')
            ->addOrderBy('h.result', 'ASC')
            ->addGroupBy('h.result');
        $results = $this->queryBuilder
            ->getQuery()
            ->getArrayResult();

        foreach ($results as $result) {
            if ($result['result'] == 1) {
                $this->setUserWins($result['cnt']);
            }

            if ($result['result'] == 2) {
                $this->setComputerWins($result['cnt']);
            }

            if ($result['result'] == 3) {
                $this->setTieGames($result['cnt']);
            }
        }
    }

    private function buildCounts()
    {
        $answers = [];
        foreach (['userChoice', 'computerChoice'] as $column) {
            $answers[$column] = [];
            $this->queryBuilder
                ->select("h.$column, COUNT(h.id) as cnt")
                ->where("h.$column IS NOT NULL")
                ->addOrderBy("h.$column", 'ASC')
                ->addGroupBy("h.$column");
            $results = $this->queryBuilder
                ->getQuery()
                ->getArrayResult();


            foreach ($results as $result) {
                $answers[$column][$result[$column]] = $result['cnt'];
            }
        }

        $this->setUserAnswers($answers['userChoice']);
        $this->setComputerAnswers($answers['computerChoice']);
    }

    public function clearStats()
    {
        $classMeta  = $this->entityManager->getClassMetadata(History::class);
        $connection = $this->entityManager->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->executeUpdate(
                $platform->getTruncateTableSql(
                    $classMeta->getTableName()
                )
            );
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * @return int
     */
    public function getTotalGames()
    {
        return $this->totalGames;
    }

    /**
     * @param int $totalGames
     * @return Statistics
     */
    public function setTotalGames($totalGames)
    {
        $this->totalGames = $totalGames;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserWins()
    {
        return $this->userWins;
    }

    /**
     * @param int $userWins
     * @return Statistics
     */
    public function setUserWins($userWins)
    {
        $this->userWins = $userWins;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserAnswers()
    {
        return $this->userAnswers;
    }

    /**
     * @param mixed $userAnswers
     * @return Statistics
     */
    public function setUserAnswers($userAnswers)
    {
        $this->userAnswers = $userAnswers;
        return $this;
    }

    /**
     * @return int
     */
    public function getComputerWins()
    {
        return $this->computerWins;
    }

    /**
     * @param int $computerWins
     * @return Statistics
     */
    public function setComputerWins($computerWins)
    {
        $this->computerWins = $computerWins;
        return $this;
    }

    /**
     * @return array
     */
    public function getComputerAnswers()
    {
        return $this->computerAnswers;
    }

    /**
     * @param array $computerAnswers
     * @return Statistics
     */
    public function setComputerAnswers($computerAnswers)
    {
        $this->computerAnswers = $computerAnswers;
        return $this;
    }

    /**
     * @return int
     */
    public function getTieGames()
    {
        return $this->tieGames;
    }

    /**
     * @param int $tieGames
     * @return Statistics
     */
    public function setTieGames($tieGames)
    {
        $this->tieGames = $tieGames;
        return $this;
    }


}