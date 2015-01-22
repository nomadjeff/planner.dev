<?php

require_once('../inc/filestore.php');

Class AddressBook extends filestore
{
	function __construct($filename)
	{
		parent:: __construct(strtolower($filename));
	}

}

// This code pulls the address book from a CSV file and throws it into an array. Make it a function?

$filename = 'address_book.csv';
$handle = fopen($filename, 'r');
$addressBook = [];

while(!feof($handle)) {
    $row = fgetcsv($handle);

    if (!empty($row)) {
        $addressBook[] = $row;
    }
}
fclose($handle);

// Check for errors if form was submitted.

if (!empty($_POST)) {

	try {
		if (strlen($_POST['name']) > 100) {
			throw new Exception('Nobody has a name that long, smartass!');
		}
		if (strlen($_POST['address']) > 100) {
			throw new Exception('Seriously?');
		}
		if (strlen($_POST['city']) > 30) {
			throw new Exception('No city name in the US is that long');
		}
		if (strlen($_POST['state']) > 2) {
			throw new Exception('Just give a 2-digit abbreviation for state!');
		}
		if (strlen($_POST['zip']) > 5) {
			throw new Exception('I do not need the fancy zip, just the regular one, please!');
		}
	} catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "<br>";
	}
	// Push the contents of $_POST onto the addressBook array
	$addressBook[] = $_POST;
	// var_dump ($addressBook);
	// var_dump ($_POST);
}


?>

<table align="center">
<td valign="top">
<h3>My Address Book</h3>
<?php

// This code generates the HTML for each address
foreach ($addressBook as $row) {
	echo $row [0] . "<br>";
	echo $row [1] . "<br>";
	echo $row [2] .", ". $row [3] ." ". $row [4] . "<br>";
	echo "<br>";
}

?>
</td>
<td width="20"><hr noshade width="1" size="500"></td>
<td valign="top">
<h3>Add a New Address</h3>
<form action="address_book.php" method="post">
<table>
	<tr>
		<td align="right"><strong>Name:</strong></td>
		<td><input type="text" name="name"></td>
	</tr>
	<tr>
		<td align="right"><strong>Address:</strong></td>
		<td><input type="text" name="address"></td>
	</tr>
	<tr>
		<td align="right"><strong>City:</strong></td>
		<td><input type="text" name="city"></td>
	</tr>
	<tr>
		<td align="right"><strong>State:</strong></td>
		<td><input type="text" name="state"></td>
	</tr>
	<tr>
		<td align="right"><strong>Zip:</strong></td>
		<td><input type="text" name="zip"></td>
	</tr>
</table>
<br>
<center><input type="submit" value="Create Address"></center>
</form>
</td>
</table>

<?php

// This code puts the array contents back into a CSV file.
// Not necessary if no changes were made.
// Commenting out for now.

// $handle = fopen('address_book.csv', 'w');

// foreach ($addressBook as $row) {
//     fputcsv($handle, $row);
// }

// fclose($handle);

?>
