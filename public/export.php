<?php
require '../src/bootstrap.php';
$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$start = new DateTimeImmutable('first day of january');
$end = $start->modify('last day of december')->modify('+ 1 day');
$events = $events->getEventsBetween($start,$end);

?>

id,nom,start,end
<?php foreach($events as $event): ?>
<?= $event->getId(); ?>;"<?= addslashes($event->getName()) ?>"; "<?= $event->getStart()->format('Y-m-d'); ?>";"<?= $event->getEnd()->format('Y-m-d'); ?>"
<?php endforeach; ?>
