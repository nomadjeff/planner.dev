<?php

require_once('../inc/filestore.php');

$todo_list = new Filestore('../data/todo.txt');

$todo_list->contents = $todo_list->read();

if(!empty($_POST['NewItem'])) {
    $todo_list->contents[] = $_POST['NewItem'];
    $todo_list->write($todo_list->contents);
}


// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
 

    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';


    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

	$new_items_array = openFile($savedFilename);

	$todo_array = array_merge($todo_array, $new_items_array);

}

if (!empty($_POST)) {
	var_dump($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Jeff's Christmas To-Do List</title>
</head>
<body>
<h3>Jeff's Christmas Shopping List</h3>
<form action="todo_new.php" enctype="multipart/form-data" method="post">
<?php

foreach($todo_list->contents as $value) {
	echo "<input type='checkbox' name='".$value."'> ".$value."<br>".PHP_EOL;
};
?>
<br>
<input type="text" name="NewItem">
<br><br>
<label for="file1">File to upload: </label>
<input type="file" id="file1" name="file1">
<br><br>
<input type="submit" name="Update">	
</form>
</body>
</html>