<?php
require __DIR__ . '/testdb.php';



$query ='TRUNCATE national_parks;';

$dbc->exec($query);

$parks = [
    ['name' => 'Yellow Stone',   'location' => 'Wyoming/Montana/Idaho', 'date_established' => '1872-03-01', 'area_in_acres' => 2220000, 'description' => 'Yellowstone features dramatic canyons, alpine rivers, lush forests, hot springs and gushing geysers, including its most famous, Old Faithful.'],
    ['name' => 'Death Valley',   'location' => 'California/Nevada', 'date_established' => '1994-10-31', 'area_in_acres' => 3373063, 'description' => "Death Valley National Park straddles eastern California and Nevada. It’s known for Titus Canyon, with a ghost town and colorful rocks, and Badwater Basin’s salt flats, North America's lowest point."],
    ['name' => 'Denali',   'location' => 'Alaska', 'date_established' => '1917-02-26', 'area_in_acres' => 4740911, 'description' => 'Denali is the highest mountain peak in North America, with a summit elevation of 20,310 feet above sea level.'],
    ['name' => 'Olympic',   'location' => 'Washington', 'date_established' => '1938-06-29', 'area_in_acres' => 922650, 'description' => 'BEST EVER!!!!!'],
    ['name' => 'Pinnacles',   'location' => 'California', 'date_established' => '2013-01-03', 'area_in_acres' => 26685, 'description' => 'Pinnacles National Park is a U.S. National Park protecting a mountainous area located east of the Salinas Valley in Central California, about 5 miles east of Soledad and 80 miles southeast of San Jose.'],
    ['name' => 'Redwood',   'location' => 'California', 'date_established' => '1968-10-02', 'area_in_acres' => 536297, 'description' => 'The Redwood National and State Parks are old-growth temperate rainforests located in the United States, along the coast of northern California.'],
    ['name' => 'Rocky Mountain',   'location' => 'Colorado', 'date_established' => '1915-01-26', 'area_in_acres' => 4517585, 'description' => 'Rocky Mountain National Park in northern Colorado spans the Continental Divide and encompasses protected mountains, forests and alpine tundra'],
    ['name' => 'Saguaro',   'location' => 'Arizona', 'date_established' => '1994-10-14', 'area_in_acres' => 820426, 'description' => 'he park is named for the large saguaro cactus, native to its desert environment. In the western Tucson Mountain District, Signal Hill Trail leads to petroglyphs of the ancient Hohokam people.'],
    ['name' => 'Sequoia',   'location' => 'California', 'date_established' => '1890-9-25', 'area_in_acres' => 1254688, 'description' => "It's known for its huge sequoia trees, notably the General Sherman Tree dominating the Giant Forest"],
    ['name' => 'Yosemite',   'location' => 'California', 'date_established' => '1890-10-1', 'area_in_acres' => 5028868, 'description' => "Yosemite National Park is in California’s Sierra Nevada mountains. It’s famed for its giant, ancient sequoia trees, and for Tunnel View, the iconic vista of towering Bridalveil Fall and the granite cliffs of El Capitan and Half Dome"]

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
