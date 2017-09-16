<?php

	function load_xml($feed_url) {

		// Add http before loading the URL
		$feed_url = add_http($feed_url);

		// Checks if given URL is a valid RSS/Atom feed. If not, exit with error.
		$xml = simplexml_load_file($feed_url) or die(
			"<div class=\"alert alert-danger\" role=\"alert\"\">
				<span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
				&nbsp;Invalid feed URL. Please enter a valid RSS/Atom URL.	
			</div>");		
		return $xml;
	
	}

	function add_http($feed_url) {

		// Check if http is present or not, if not add it
		if(!preg_match("~^(?:f|ht)tps?://~i", $feed_url)) {
			$feed_url = "http://" . $feed_url;
		}

		return $feed_url;
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
				echo "<h4>" . format_date($post->pubDate) . "</h4>";
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

<?php require 'templates/header.php' ?>

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
	</div>

	<?php require 'templates/footer.php' ?>
</body>
</html>
