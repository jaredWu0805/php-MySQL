<?php
	require_once('conn.php');

	$id = $_POST["id"];
	$title = $_POST["title"];
	$desc = $_POST["description"];
	$sal = $_POST["salary"];
	$link = $_POST["link"];

	if (empty($title) || empty($desc) || empty($sal) || empty($link)) {
		die("Some info is missing");
	}

	$updateSQL = 
		// "UPDATE jobs SET title=". $title ." description=". $desc ." salary=". $sal ." link=". $link ." WHERE id=". $id;
		"UPDATE jobs SET title='$title', description='$desc', salary='$sal', link='$link' WHERE id=$id";

	echo '<br>'. $updateSQL .'<br>';
	$result = $conn->query($updateSQL);
	if ($result) {
		header("Location: ./admin.php");
	} else {
		echo "Update failed - " . $conn->error;
	}
	
?>