<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Calendrier</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3">
<a class="navbar-brand" href="/index.php">Mon calendrier</a>
</nav>
<?php 
require '../src/Date/Month.php';
$month = new App\Date\Month( 0, 2018); 
?>


</body>

</html>