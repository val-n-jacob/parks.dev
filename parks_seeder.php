<?php
require __DIR__ . '/testdb.php';



$query ='TRUNCATE national_parks;';

$dbc->exec($query);

$parks = [
    ['name' => 'Yellow Stone',   'location' => 'Wyoming/Montana/Idaho', 'date_established' => '1872-03-01', 'area_in_acres' => 2220000, 'description' => DESCRIPTION],
    ['name' => 'Death Valley',   'location' => 'California/Nevada', 'date_established' => '1994-10-31', 'area_in_acres' => 3373063, 'description' => DESCRIPTION],
    ['name' => 'Denali',   'location' => 'Alaska', 'date_established' => '1917-02-26', 'area_in_acres' => 4740911, 'description' => DESCRIPTION],
    ['name' => 'Olympic',   'location' => 'Washington', 'date_established' => '1938-06-29', 'area_in_acres' => 922650, 'description' => DESCRIPTION],
    ['name' => 'Pinnacles',   'location' => 'California', 'date_established' => '2013-01-03', 'area_in_acres' => 26685, 'description' => DESCRIPTION],
    ['name' => 'Redwood',   'location' => 'California', 'date_established' => '1968-10-02', 'area_in_acres' => 536297, 'description' => DESCRIPTION],
    ['name' => 'Rocky Mountain',   'location' => 'Colorado', 'date_established' => '1915-01-26', 'area_in_acres' => 4517585, 'description' => DESCRIPTION],
    ['name' => 'Saguaro',   'location' => 'Arizona', 'date_established' => '1994-10-14', 'area_in_acres' => 820426, 'description' => DESCRIPTION],
    ['name' => 'Sequoia',   'location' => 'California', 'date_established' => '1890-9-25', 'area_in_acres' => 1254688, 'description' => DESCRIPTION],
    ['name' => 'Yosemite',   'location' => 'California', 'date_established' => '1890-10-1', 'area_in_acres' => 5028868, 'description' => DESCRIPTION]

];

foreach ($parks as $park) {
    $query = <<<SQL
    INSERT INTO national_parks (name, location, date_established, area_in_acres, description)
    VALUES (
        '{$park['name']}',
        '{$park['location']}',
        '{$park['date_established']}',
        '{$park['area_in_acres']}',
        '{$park['description']}'
    );
SQL;

    $dbc->exec($query);
}
