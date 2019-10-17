<?php

namespace Calendar;

class Events
{
    /**
     * Récuperer les événements commençant entre deux dates
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getEventsBetween(\DateTime $start, \DateTime $end): array
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=calendar', 'root', 'root', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' and '{$end->format('Y-m-d 23:59:59')}'";
        $statement = $pdo->query($sql);
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
     */
    public function find(int $id)
    {

    }
}
