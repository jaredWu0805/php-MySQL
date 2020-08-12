<?php
	require_once('conn.php');

	$id = $_GET['id'];
	$delSQL = 'DELETE from jobs WHERE id='. $id;

	$result = $conn->query($delSQL);
	if ($result) {
		header("Location: ./admin.php");
	} else {
		echo "Delete failed - " . $conn->error;
	}
?>