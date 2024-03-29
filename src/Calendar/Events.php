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
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return Event[]
     */
    public function getEventsBetween(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' and '{$end->format('Y-m-d 23:59:59')}' ORDER BY start ASC";
        $statement = $this->pdo->query($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $resultats = $statement->fetchAll();
        return $resultats;
    }
    /**
     * Récuperer les événements commençant entre deux dates indé par jour
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    public function getEventsBetweenByDay(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach ($events as $event) {
            $date = $event->getStart()->format('Y-m-d');
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

     /**
     * @param Event $event
     * @param array $data
     * @return Event
     */
    public function hydrate(Event $event, array $data)
    {
        $event->setName($data['name']);
        $event->setDescription($data['description']);
        $event->setStart(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));
        return $event;
    }

     /**
     * création d'un événement au niveau de la base de données
     * @param Event $event
     * @return bool
     */
    public function create(Event $event):bool
    {
        $statement = $this->pdo->prepare('INSERT INTO events (name, description, start, end) VALUES (?,?,?,?)');
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Met à jour un événement au niveau de la base de données
     * @param Event $event
     * @return bool
     */
    public function update(Event $event):bool
    {
        $statement = $this->pdo->prepare('UPDATE events SET name= ?, description= ?, start= ?, end= ? WHERE id = ?'); 
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getId()
        ]);
    }

    /**
     * TODO: supprime un événement
     * @param Event $event
     * @return bool
     */
    public function delete():bool
    {
        $statement = $this->pdo->prepare('DELETE FROM events WHERE id= :id');
        return $statement->execute(array(
            ':id' => $_GET['id']
        ));
    }
}
