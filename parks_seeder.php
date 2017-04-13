<?php
require __DIR__ . '/testdb.php';



$clearParks ='TRUNCATE national_parks;';

$parks = [
    ['name' => 'Yellow Stone',   'location' => 'Wyoming/Montana/Idaho', 'date_established' => '1872-03-01', 'area_in_acres' => 2220000 ],
    ['name' => 'Death Valley',   'location' => 'California/Nevada', 'date_established' => '1994-10-31', 'area_in_acres' => 3373063 ],
    ['name' => 'Denali',   'location' => 'Alaska', 'date_established' => '1917-02-26', 'area_in_acres' => 4740911 ],
    ['name' => 'Olympic',   'location' => 'Washington', 'date_established' => '1938-06-29', 'area_in_acres' => 922650 ],
    ['name' => 'Pinnacles',   'location' => 'California', 'date_established' => '2013-01-03', 'area_in_acres' => 26685 ],
    ['name' => 'Redwood',   'location' => 'California', 'date_established' => '1968-10-02', 'area_in_acres' => 536297 ],
    ['name' => 'Rocky Mountain',   'location' => 'Colorado', 'date_established' => '1915-01-26', 'area_in_acres' => 4517585 ],
    ['name' => 'Saguaro',   'location' => 'Arizona', 'date_established' => '1994-10-14', 'area_in_acres' => 820426 ],
    ['name' => 'Sequoia',   'location' => 'California', 'date_established' => '1890-9-25', 'area_in_acres' => 1254688 ],
    ['name' => 'Yosemite',   'location' => 'California', 'date_established' => '1890-10-1', 'area_in_acres' => 5028868 ]

];

$dbc->exec($clearParks);

foreach ($parks as $park) {
    $query = "INSERT INTO national_parks (name, location, date_established, area_in_acres) VALUES ('{$park['name']}', '{$park['location']}', '{$park['date_established']}', '{$park['area_in_acres']}')";

    $dbc->exec($query);

    echo "parks added " . $dbc->lastInsertId() . PHP_EOL;
}
