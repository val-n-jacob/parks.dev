<?php

require __DIR__ . '/constants.php';


// $connection = new PDO ('mysql:host=localhost;dbname=employees','vagrant','vagrant');

// echo $connection->getAttribute(PDO::ATTR_CONNECTION_STATUS), PHP_EOL;

// Get new instance of PDO object
$dbc = new PDO('mysql:host='. DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

