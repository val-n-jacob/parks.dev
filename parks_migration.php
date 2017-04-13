<?php 

require __DIR__ . '/testdb.php';


$query = 'DROP TABLE IF EXISTS national_parks;';

$natParks = 'CREATE TABLE national_parks (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
name VARCHAR (100) NOT NULL,
location VARCHAR(100) NOT NULL, 
date_established DATE,
area_in_acres INT,
PRIMARY KEY (id)
);';


$dbc->exec($query);
$dbc->exec($natParks);