<?php 
require '../src/bootstrap.php';

use Calendar\{
    Events,
    Month
};
$pdo = get_pdo();
$events = new Events($pdo);
try {
$month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null); 

}catch (\Exception $e){
    $month = new App\Date\Month();
}
$start = $month->getStartingDay();
$start = $start->format('N') === '1' ? $start :$month->getStartingDay()->modify('Last monday');
$week = $month->getWeeks();
$end = (clone $start)->modify('+' . (6 + 7 * ($week - 1)) . ' days');
$events = $events->getEventsBetweenByDay($start,$end);
require '../views/header.php';
?>
<div class="div calendar">
    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1><?= $month->toString(); ?></h1>
        <div class="container">
        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            L'événement a bien été enregistré !
        </div>
        <?php endif; ?>
    </div>
        <div>
            <a href="/index.php?month=<?= $month->previousMonth()->month; ?>&year=<?=$month->previousMonth()->year; ?>"
                class="btn btn-primary">&lt</a>
            <a href="/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?=$month->nextMonth()->year; ?>"
                class="btn btn-primary">&gt</a>
        </div>
    </div>
    <table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
        <?php for($i = 0; $i<$month->getWeeks(); $i++): ?>
        <tr>
            <?php foreach($month->days as $k =>$day): 
                $date = (clone $start)->modify("+" . ($k + $i *7) . "days");
                $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                $isToday = date('Y-m-d') == $date->format('Y-m-d');
                ?>
            <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?><?= $isToday ? 'is-today' : ''; ?>">
                <?php if($i === 0): ?>
                <div class="calendar__weekday"> <?= $day; ?></div>
                <?php endif; ?>
                <a class="calendar__day" href="add.php?date=<?=$date->format('Y-m-d'); ?>"><?=$date->format('d'); ?>
</div>
<?php foreach($eventsForDay as $event): ?>
<div class="calendar__event">
    <?= (new DateTime($event['start']))->format('H:i') ?> - <a
        href="/edit.php?id=<?= $event['id']; ?>"><?= h($event['name']); ?></a>
</div>
<?php endforeach; ?>
</td>
<?php endforeach; ?>
</tr>

<?php endfor; ?>
</table>

<a href="/add.php" class="calendar__btn">+</a>
</div>

<?php
require '../views/footer.php';

?>