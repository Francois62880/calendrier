<?php
require '../src/bootstrap.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$errors = [];
if (!isset($_GET['id'])) {
    e404();
}
try {
    $event = $events->find($_GET['id']);
} catch (\Exception $e) {
    e404();
}
$data = [
    'name' => $event->getName(),
    'date' => $event->getStart()->format('Y-m-d'),
    'descrption' => $event->getDescription(),
    'start' => $event->getStart()->format('H:i'),
    'end' => $event->getEnd()->format('H:i')
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($data);
    if (empty($errors)) {
        $events->hydrate($event, $data);
        $events->update($event);
        header('location: /index?success=1');
        exit();
    }
}

render('header', ['title'=> $event->getName()]);
?>
<div class="container">
    <h1>Editer l'événement : <small><?= h($event->getName()); ?></small></h1>
    <form action="" method="post" class="form">
        <?php render('calendar/form' , ['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Modifier l'événement</button>
        </div>
        <div class="form-group">
            <a href="supprimer.php?numevent=<?= $event['id'] ?>"><button class="btn btn-primary">Supprimer l'événement</button></a>
        </div>
    </form>
</div>
<?php
render('footer');
?>