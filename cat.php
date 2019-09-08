<?php
ob_start(); 

require "database.php";

$url = $_POST["url"];

$sql = 'INSERT INTO categories (categories) VALUES ("'.$url.'")';

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("Location: http://euroitsolution.com/m2/scrapping/insertcategory.php"); 
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>