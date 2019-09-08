<?PHP
function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}


// Set path to CSV file
$csvFile = 'contacts.csv';

$csv = readCSV($csvFile);

echo  count($csv);

?>

<table>
<?php foreach($csv as $data) :?>
<tr>
<?php foreach($data as $dataItem) :?>

    <td>
        <?php echo $dataItem;?>
    </td>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>

<table>







<!-- echo '<pre>';
print_r($csv);
echo '</pre>'; -->
?>