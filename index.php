<?php
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters
header('Content-type: text/html; charset=utf-8');
use Web\Controller;
require_once __DIR__ . "/src/Web/Controller.php";
$url = 'https://www.example.com/';
if (isset($_GET['search'])) {
	$url = htmlspecialchars($_GET["search"]);
}
$max = 1;
if (isset($_GET['limit'])) {
	$max = htmlspecialchars($_GET["limit"]);
}
if (!is_numeric($max)) {
	$max = 1;
}
$sec = 5;
if (isset($_GET['time'])) {
	$sec = htmlspecialchars($_GET["time"]);
}
if (!is_numeric($sec)) {
	$sec = 5;
}
set_time_limit(30 + $sec);
$how = '';
if (isset($_GET['method'])) {
	$how = htmlspecialchars($_GET["method"]);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta content="Clifford Peters" name="author">
		<meta content="Web Crawler" name="description">
		<meta content="PhpStorm" name="generator">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<title>
			Web Crawler
		</title>
		<link href="https://getbootstrap.com/docs/4.4/examples/sign-in/" rel="canonical">
		<link crossorigin="anonymous"
				href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css"
				integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt"
				rel="stylesheet">
		<meta content="#563d7c" name="theme-color">
		<style>
			html,
			body {
				height: 100%;
			}
			body {
				background-color: #f5f5f5;
				height: <?php echo 800 + 100 * $max; ?>px;
			}
			.form-signin .form-control {
				position: relative;
				box-sizing: border-box;
				padding: 10px;
				font-size: 16px;
			}
		</style>
	</head>
	<body class="text-center">
		<div class="container">
			<h1 class="h3 mb-3 font-weight-normal"><i>~ Web Crawler ~</i></h1>
			<p>Published 2019-12-08T23:52Z</p>
			<br/>
			<img alt="Frostbite Spider" height="360" src="frostbite-spider.jpg" width="640">
			<br/>
			<form>
				<br/>
				<div class="form-group">
					<label for="search">Enter Search URL</label>
					<input class="form-control" id="search" name="search" type="text" value="<?php echo $url; ?>">
				</div>
				<br/>
				<div class="form-group">
					<label for="limit">Max Results</label>
					<input class="form-control" id="limit" name="limit" type="number" value="<?php echo $max; ?>"/>
				</div>
				<div class="form-group">
					<label for="time">Max Time Seconds</label>
					<input class="form-control" id="time" name="time" type="number" value="<?php echo $sec; ?>"/>
				</div>
				<br/>
				<div class="row">
					<!-- Database this was connected to has been shut down. I should make a new one sometime.
					<div class="col-6">
						<button class="btn btn-lg btn-secondary btn-block" name="method" type="submit" value="search">Search the database!</button>
					</div>
					<div class="col-6">-->
					<div class="col-12">
						<button class="btn btn-lg btn-primary btn-block" name="method" type="submit" value="crawl">Crawl the web!</button>
					</div>
				</div>
			</form>
			<br />
			<h3><?php
if ($how === 'crawl') {
	echo 'Web Results';
}
elseif ($how === 'search') {
	echo 'Database Results';
}
else {
	echo 'Select Action';
}
?></h3>
			<div class="row" id="results">
<?php
if ($how === 'crawl') {
	Controller::Crawl($url, $max, $sec);
}
if ($how === 'search') {
	Controller::Search($url, $max);
}
?>
			</div>
		</div>
	</body>
</html>
