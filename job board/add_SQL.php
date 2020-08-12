<?php
	require_once('conn.php');

	$title = $_POST["title"];
	$desc = $_POST["description"];
	$sal = $_POST["salary"];
	$link = $_POST["link"];

	if (empty($title) || empty($desc) || empty($sal) || empty($link)) {
		die("Some info is missing");
	}

	$addSQL = 
		"INSERT INTO jobs(title, description, salary, link) 
				VALUES ('$title', '$desc', '$sal', '$link')";
		

	$result = $conn->query($addSQL);
	if ($result) {
		header("Location: ./admin.php");
	} else {
		echo "insert failed - " . $conn->error;
	}
	
?>