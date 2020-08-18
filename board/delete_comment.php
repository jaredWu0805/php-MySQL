<?php
	require_once('conn.php');

	$id = $_GET['id'];
	$delSQL = "DELETE FROM jaredWu0805_comments WHERE id=" . $id;

	$result = $conn->query($delSQL);

	if (!$result) die('Delete failed' . $conn->error);

	header('Location: ./index.php');
?>