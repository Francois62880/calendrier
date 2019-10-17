<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/calendar.css">
    <title>Calendrier</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3">
        <a class="navbar-brand" href="/index.php">Mon calendrier</a>
    </nav>
    <?php 
require '../src/Date/Month.php';
try {
$month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null); 

}catch (\Exception $e){
    $month = new App\Date\Month();
}
$start = $month->getStartingDay()->modify('Last monday');
?>
    <h1><?= $month->toString(); ?></h1>

    <table class="calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
        <?php for($i = 0; $i<$month->getWeeks(); $i++): ?>
        <tr>
            <?php foreach($month->days as $k =>$day): ?>
            <td>
                <?php if($i === 0): ?>
                <div class="calendar__weekday"> <?= $day; ?></div>
                <?php endif; ?>
                <div class="calendar__day"><?= (clone $start)->modify("+" . ($k + $i *7) . "days")->format('d'); ?>
                </div>
            </td>
            <?php endforeach; ?>
        </tr>

        <?php endfor; ?>
    </table>

</body>

</html>