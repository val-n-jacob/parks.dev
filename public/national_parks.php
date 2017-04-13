<?php

require_once '../Input.php';
require_once '../Functions.php';
require_once '../db_connect.php';

function pageController($dbc)
{
	$data = [];

	$data['pageno'] = Input::get('p', 1);

	$offset = ($data['pageno'] - 1) * 4;

	$limit = Input::get('l', 4);

	$query = <<<SQL
	SELECT *
	FROM national_parks
	LIMIT ?, ?;
SQL;

	$stmt = $dbc->prepare($query);

	Functions::bindAll([$offset, $limit], $stmt);

	$stmt->execute();

	$data['parks'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$data['headers'] = ['name' => 'Name', 'location' => 'Location', 'date_established' => 'Date Established', 'area_in_acres' => 'Area in Acres', 'description' => 'Description'];

	Functions::bindAll([0, PHP_INT_MAX], $stmt);

	$stmt->execute();

	$rows = $stmt->rowCount();

	$data['pages'] = $rows === 0 ? 1 : (int) ceil($rows / 4);

	return $data;
}

function validateDate($date)
{
	$d = DateTime::createFromFormat('Y-m-d', $date);
	return $d && $d->format('Y-m-d') === $date;
}

function getNewRow() {
	$row = [];
	$row['name'] = Input::get('name');
	$row['location'] = Input::get('location');
	$row['date_established'] = Input::get('date_established');
	$row['area_in_acres'] = Input::get('area_in_acres');
	$row['description'] = Input::get('description');

	foreach ($row as $key => &$column) {
		$column = Functions::escape($column);
		if (empty($column) and $key !== 'description') return NULL;
	}

	if (empty($row['description'])) $row['description'] = NULL;
	$row['area_in_acres'] = (float) $row['area_in_acres'];

	if (!validateDate($row['date_established'])) return NULL;
	
	return $row;

}

function add($dbc) {
	$row = getNewRow();

	if ($row === NULL) return;

	$query = <<<SQL
	INSERT INTO national_parks (name, location, date_established, area_in_acres, description)
	VALUES (:name, :location, :date_established, :area_in_acres, :description);
SQL;

	$stmt = $dbc->prepare($query);

	Functions::bindAll($row, $stmt);

	$stmt->execute();
}

extract(pageController($dbc));

if (!empty($_POST)) add($dbc);

?>

<!DOCTYPE html>
<html>
<head>
	<title>All Parks</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/national_parks.css"></style>
</head>
<body>
	<main>
		<form action="./national_parks.php" method="POST">
			<table class="table table-bordered table-striped">
				<h1>National Parks</h1>
				<?= Functions::renderTable($parks, $headers, ['id']); ?>
				<tr id="add-row">
					<td colspan="100%">
						<a id="add">Add</a>
					</td>
					<td class="hidden">
						<textarea class="add" rows="1" id="add-name" name="name" required></textarea>
					</td>
					<td class="hidden">
						<textarea class="add" rows="1" id="add-location" name="location" required></textarea>
					</td>
					<td class="hidden">
						<textarea class="add" rows="1" id="add-date" name="date_established" required></textarea>
					</td>
					<td class="hidden">
						<textarea class="add" rows="1" id="add-area" name="area_in_acres" required></textarea>
					</td>
					<td class="hidden">
						<textarea class="add" rows="1" id="add-description" name="description"></textarea>
					</td>
				</tr>
			</table>
			<div class="text-center">
				<button type="submit" class="hidden btn btn-primary" id="submit">Submit</button>
			</div>
		</form>
		<?php if ($pageno > 1): ?>
			<a href="./national_parks.php?p=<?= $pageno - 1 ?>" id="prev">&#60; Prev</a>
		<?php endif ?>
		<?php if ($pageno < $pages): ?>
			<a href="./national_parks.php?p=<?= $pageno + 1 ?>" id="next">Next &#62;</a>
		<?php endif ?>
	</main>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.20/autosize.min.js"></script>
	<script src="./js/national_parks.js"></script>
</body>
</html>