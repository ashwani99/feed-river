<!DOCTYPE html>
<html>

<?php require 'templates/header.php' ?>

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

		
	</div>

	<?php require 'templates/footer.php' ?>
</body>
</html>