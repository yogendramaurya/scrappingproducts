<?php
// DELETE t1 FROM product t1 INNER JOIN product t2 WHERE t1.id < t2.id AND t1.sku = t2.sku 
ini_set('display_errors', '1');
require 'vendor/autoload.php';
use Goutte\Client;
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "scrappin";
$page = 0;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
#require "database.php";

/* Fetch category urls*/
$sql = "SELECT url FROM producturls where status=0";
$result = $conn->query($sql);

// echo $result->num_rows;

echo "There are $result->num_rows urls to process...............................\n";
$file = fopen("contacts.csv","w");
$header = array('name', 'sku', 'ean', 'detail', 'images', 'price', 'categories');
fputcsv($file, $header);

$errorURL = array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$url = $row["url"];		
		try {
			scrapURL($conn, $url, $file);
			$status = 'UPDATE producturls SET status=1 WHERE url="'.$url.'"';

			if ($conn->query($status) === TRUE) {
				echo "-";
			} else {
				$errorURL[$url] = $conn->error;
			}
			usleep(2);
		} catch (Exception $th) {
			// echo $th->getMessage();
			$errorURL[$url] = $th->getMessage();
		}
    }
} else {
    echo "0 results";
}


fclose($file);

function scrapURL($conn, $url, $file)
{
	
	$css_selector = "#podstrona_content h1";
	$thing_to_scrape = "_text";

	$client = new Client();
	$crawler = $client->request('GET', $url);
	$name = $crawler->filter($css_selector)->extract($thing_to_scrape);
	$sku = $crawler->filter(".product_pn_ean_brick strong")->extract("_text");
	$images = $crawler->filter(".galeria")->extract("href");
	$price = $crawler->filter(".cena_red")->extract("_text");
	$breadcrumb_span = $crawler->filter(".breadcrumb_span")->extract("_text");

	try{
		$description = @$crawler->filter("#product_specification")->html();
	} catch (Exception $th) {
		// echo $th->getMessage();
		$description = $name[0];
	}

	//$description = addslashes($description);

	// $td = array($name[0], $sku,$images, $price, array_unique($breadcrumb_span));

	 $image = implode("|", $images);
	 $categories = implode("|", array_unique($breadcrumb_span));

	 $image = !empty($image) ? $image : null;
	
	 $sku_d = $sku[0];
	 $sku_e = @$sku[1];
	$priced = $price[0];
	//$row = array('name', 'sku', 'ean', 'detail', 'images', 'price', 'categories');
	$line = array($name[0],$sku_d,$sku_e, $description, $image, $priced, $categories);
	print_r($line);
	
	fputcsv($file, $line);
	return;
}
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}


$conn->close();
?>