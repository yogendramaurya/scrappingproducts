<?php
require 'vendor/autoload.php';
use Goutte\Client;

require "database.php";

/* Fetch category urls*/
$sql = "SELECT categories FROM categories where status=0 limit 100";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $url = $row["categories"];
        scrapURL($conn, $url);
        $status = 'UPDATE categories SET status=1 WHERE categories="'.$url.'"';

		if ($conn->query($status) === TRUE) {
		    echo "Record updated successfully"."\n";
		} else {
		    echo "Error updating record: " . $conn->error."\n";;
		}

		usleep(100);
    }
} else {
    echo "0 results";
}

function scrapURL($conn, $url)
{
	$css_selector = ".tytul_opis a";
	$thing_to_scrape = "href";

	$client = new Client();
	$crawler = $client->request('GET', $url);
	$output = $crawler->filter($css_selector)->extract($thing_to_scrape);
	//echo "<pre>";
	// var_dump($output);
	$nurls = array_unique($output);
	foreach ($nurls as $key => $value) {
			$sql = 'INSERT INTO producturls (url) VALUES ("'.$value.'")';

			if ($conn->query($sql) === TRUE) {
			    echo ".";
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
	}

	return;
}


$conn->close();
?>