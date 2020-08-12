<?php
	require_once('conn.php');


	// MySQL insert method

	if(empty($_POST['username'])) {
		die('<br> Please fill in username '. $_POST['username']);
	}

	$username = $_POST['username'];

	$sql = sprintf(
		"insert into usertable(username) values('%s')", 
		$username
	);

	$insert = $conn->query($sql);

	if (!$insert) {
		die($conn->error);
	}

	
	header("Location: index.php");
?>	

