<?php 

require __DIR__ . '/testdb.php';


$query = 'DROP TABLE IF EXISTS national_parks;';
$dbc->exec($query);

$query = <<<SQL
CREATE TABLE national_parks (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR (100) NOT NULL,
	location VARCHAR(100) NOT NULL, 
	date_established DATE,
	area_in_acres INT,
	description TEXT,
	PRIMARY KEY (id)
);
SQL;

$dbc->exec($query);