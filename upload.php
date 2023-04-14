<?php
	session_start();
?>

<?php

$con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
// Check Connection
if (!$con) {
      die("Connection failed: " . mysqli_connect_error() . "<br>");
}

if (isset($_POST['submit'])) {
	$file = $_FILES['file'];

	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];
	$fileError = $_FILES['file']['error'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$userId = $_SESSION['userId'];
	$email = $_SESSION['email'];
	
	
	$get_fname = "Select fname AS get_fname from User WHERE email='$email'";
        $result1= $con->query($get_fname);
        $value1 = mysqli_fetch_object($result1);
        $get_fname = $value1->get_fname;

	$allowed = array('jpg', 'jpeg', 'png');
	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 500000) {
				$fileNameNew = $get_fname . "_" . $userId .  "."  . $fileActualExt;
				$fileDestination = "images/".$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
			} else {
				echo "Your file is too big!";
			}
		} else {
			echo "There was an error uploading your file!";
		}
	} else {
		echo "This is not an image! You may only upload images!";
	}
}
$con->close();
header('location: viewUser.php');

?>
