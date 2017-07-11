<?php

	function load_xml($feed_url) {

		// Checks if given URL is a valid RSS/Atom feed. If not, exit with error.
		$xml = simplexml_load_file($feed_url) or die(
			"<div class=\"alert alert-danger\" role=\"alert\"\">
				<span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
				&nbsp;Invalid feed URL. Please enter a valid RSS/Atom URL.	
			</div>");		
		return $xml;
	
	}

	function load_atom_feed($xml) {
		
		$feed = array();


		$xml->registerXPathNamespace("atom", "http://www.w3.org/2005/Atom");
		foreach ($xml->xpath("//atom:entry") as $entry) {
			array_push($feed, $entry);
		}

		return $feed;
	
	}

	function load_rss_feed($xml) {

		$feed = array();
		foreach ($xml->xpath("//item") as $item) {
			array_push($feed, $item);
		}

		return $feed;	

	}

	function format_date($date) {
		
		// Convert the date to a simpler format
		return date('d F, Y G:i e', strtotime($date));
	}

	function load_feed($xml) {

		$feed = array();

		// Check if the feed is RSS or Atom and create feed from XML object
		if($xml->channel) {
			$feed = load_rss_feed($xml);
			
			// Sort the posts with order latest post first
			usort($feed, function($post1, $post2) {
				return strtotime($post2->pubDate) - strtotime($post1->pubDate);
			});
		}
		else {
			$feed = load_atom_feed($xml);

			// Sort the posts with order latest post first
			usort($feed, function($post1, $post2) {
				return strtotime($post2->updated) - strtotime($post1->updated);
			});	
		}

		return $feed;
	} 

	function display_posts($feed, $is_rss) {

		if($is_rss) {
			foreach ($feed as $post) {
				echo "<h2><a href=" . $post->link . ">" . $post->title . " (" . $post->author . ")" ."</a></h2>";
				echo "<p>" . format_date($post->pubDate) . "</p>";
				echo "<p>" . $post->description . "</p>";
				echo "<br><br><br>";
			}
		}
		else {
			foreach ($feed as $post) {
				echo "<h2><a href=" . $post->link['href'] . ">" . $post->title . " (" . $post->author->name . ")" ."</a></h2>";
				echo "<h4>" . format_date($post->updated) . "</h4>";
				echo "<p>" . $post->content . "</p>";
				echo "<br><br><br>";
			}
		}
	}

?>

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

	<header>
		<div class="navbar navbar-default">
			<div class="navbar-header"><a class="navbar-brand" href="index.php">Feed-River</a></div>	
		</div>
	</header>

	<div class="col-xs-12 col-md-12 col-xs-12"">
		<div class="container-fluid">
			<?php 

				$url = $_GET['siteurl'];
				$xml = load_xml($url);

				$posts = load_feed($xml);
			?>
			<div class="post">
				<?php

					// Display posts
					($xml->channel) ? display_posts($posts, true) : display_posts($posts, false);

				
				?>
			</div>
		</div>

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
