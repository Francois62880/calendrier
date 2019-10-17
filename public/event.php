<?php
require '../src/Calendar/Events.php';
require '../views/header.php';
$events = new Calendar\Events();
if(!isset($_GET['id']))
{
    header('location: /404.php');
}
$event = $events->find($_GET['id']);
?>

<h1></h1>

<?php
require '../views/footer.php';
?>