<!DOCTYPE html>
<html>

<head>
	<title>Feed-River - A minimalistic RSS/Atom Feed Reader</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>	

	<div class="col-lg-12 col-md-12 col-xs-12 container-fluid home">
		<header class="jumbotron">
			<h1>
				<a href="/">Feed-River</a>
			</h1>
			<p><small>A minimalistic feed reader for RSS/Atom feeds</small></p>
		</header>

		<section>
			<form method="GET" action="feed.php">
				<p>
					<input id="url-box" type="text" name="siteurl" placeholder="Enter your feed URL here " required>
				</p>

				<button class="btn btn-primary submit-btn" type="submit">Read it!</button>
			</form>
		</section>

		<footer class="text-primary">
			<p>
				Feed-River&nbsp;©
				<a href="https://github.com/ashwani99">Ashwani Gupta</a>
				&nbsp;
				2017
			</p>
		</footer>
	</div>

</body>
</html>