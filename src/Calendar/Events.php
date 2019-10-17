<?php

namespace Calendar;

class Events
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Récuperer les événements commençant entre deux dates
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getEventsBetween(\DateTime $start, \DateTime $end): array
    {
        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' and '{$end->format('Y-m-d 23:59:59')}'";
        $statement = $this->pdo->query($sql);
        $resultats = $statement->fetchAll();
        return $resultats;
    }
    /**
     * Récuperer les événements commençant entre deux dates indé par jour
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getEventsBetweenByDay(\DateTime $start, \DateTime $end): array
    {
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach ($events as $event) {
            $date = explode(' ', $event['start'])[0];
            if (!isset($days[$date])) {
                $days[$date] = [$event];
            } else {
                $days[$date] = $event;
            }
        }
        return $days;
    }

    /**
     * Récupére un événement
     * @param int $id
     * @return Event
     * @throws \Exception
     */
    public function find(int $id): Event
    {
        $statement = $this->pdo->query("SELECT * FROM events WHERE id = $id  LIMIT 1");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $result=$statement->fetch();
        if ($result === false) {
            throw new \Exception('Aucun résultat n\'a été trouvé');
        }
        return $result;
    }
}
