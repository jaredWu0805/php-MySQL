<?php
	
	// MySQL delete method
	require_once('conn.php');


	if (empty($_GET['username'])){
		die('<br> Please select a username to delete');
	}

	$username = $_GET['username'];
	$delSql = sprintf(
		'DELETE from usertable where username = "%s"', 
		$username
	);
	$result = $conn->query($delSql);
	
	if (!$result) {
		die($conn->error);
	}

	if ($conn->affected_rows >= 1) {
		echo 'Success';
	} else {
		echo 'Cannot found';
	}

	header('Location: index.php');
	
?>