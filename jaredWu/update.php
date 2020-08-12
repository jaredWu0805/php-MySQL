<?php
	require_once('conn.php');

	// update MySQL
	if(empty($_POST['username']) || empty($_POST['id'])) {
		echo 'fill in the form';
	}

	$username = $_POST['username'];
	$id = $_POST['id'];

	$updateSql = sprintf(
		"UPDATE usertable SET username = '%s' WHERE id = %d", 
		$username,
		$id
	);

	$result = $conn->query($updateSql);

	if (!$result) {
		die($conn->error);
	}

	header("Location: index.php");
?>