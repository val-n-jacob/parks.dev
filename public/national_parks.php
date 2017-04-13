<?php
require __DIR__ . '/../Input.php';
require __DIR__ . '/../testdb.php';

$stmt = $dbc->query('SELECT * FROM national_parks');
$parks = $stmt->fetchALL(PDO::FETCH_ASSOC);

echo "Columns: " . $stmt->columnCount() . PHP_EOL;
while ($row = $stmt->fetch()) {
    print_r($stmt->fetch(PDO::FETCH_BOTH));
}


function getLastPage($connection, $limit) {
	$statement = $connection->query("SELECT count(*) from national_parks");
	$count = $statement->fetch()[0]; // to get the count
	$lastPage = ceil($count / $limit);
	return $lastPage;
}

function getPaginatedParks($connection, $page, $limit) {
	// offset = (pageNumber -1) * limit
	$offset = ($page - 1) * $limit;

	$select = "SELECT * from national_parks limit $limit offset $offset";
	$statement = $connection->query($select);
	return $statement->fetchAll(PDO::FETCH_ASSOC); 
}

// function handleOutOfRangeRequests($page, $lastPage) {
// 	// protect from looking at negative pages, too high pages, and non-numeric pages
// 	if($page < 1 || !is_numeric($page)) {
// 		header("location: national_parks.php?page=1");
// 		die;
// 	} else if($page > $lastPage) {
// 		header("location: national_parks.php?page=$lastPage");
// 		die;
// 	}
// }

function pageController($connection) {

	$data = [];
	
	$limit = 4;
	$page = Input::get('page', 1);

	$lastPage = getLastPage($connection, $limit);

	// handleOutOfRangeRequests($page, $lastPage);

	$data['parks'] = getPaginatedParks($connection, $page, $limit);
	$data['page'] = $page;
	$data['lastPage'] = $lastPage;

	return $data;
}

extract(pageController($dbc));


?>
<!DOCTYPE html>
	<html lang="en-us">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="x-ua-compatible" content="ie=edge">
		
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="description" content="">
		<meta name="Keywords" content="">
	    <meta name="author" content="">
		<title></title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="parkz.css">
	
	<!-- Custom CSS -->
	<style>
		body {
    background-color:#F7F7F7;
}
	</style>
	</head>
	<body>
		<main class="container">
		<h1>Welcome to National Parks</h1>
		<div class = "box">
			

			<section class="parks">
				<table class="table tablz">
					<tr>
						<th class="activez">Park Name: </th>
						<th class="activez">Location: </th>
						<th class="activez">Area in Acres: </th>
						<th class="activez">Date Established: </th>
						<th class="activez">Description: </th>
					</tr>
					<?php foreach($parks as $park): ?>
						<tr>
							<td class="activez"><?= $park['name'] ?></td>
							<td class="activez"><?= $park['location'] ?></td>
							<td class="activez"><?= $park['area_in_acres']?> acres</td>
							<td class="activez"><?= $park['date_established']?></td>
							<td class="activez"><?= $park['description']?></td>
						</tr>
					<?php endforeach; ?>	
				</table>

				<?php if($page > 1): ?>
					<a href="?page=<?= $page - 1 ?>"><span class="glyphicon glyphicon-chevron-left">Previous</span></a>
				<?php endif; ?>
				
				<?php if($page < $lastPage): ?>	
					<a class="pull-right" href="?page=<?= $page + 1 ?>"><span class="glyphicon glyphicon-chevron-right">Next</span></a>
				<?php endif; ?>

			</section>
			</div>
		</main>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
		<!-- Your custom JS goes here -->
		<script type="text/javascript"></script>
	</body>
	</html>
	
