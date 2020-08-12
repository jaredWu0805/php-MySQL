<?php
	require_once('conn.php');

	$nickname= $_POST['nickname'];
	$content = $_POST['content'];
	$addSQL = "INSERT INTO comments (nickname, content) VALUES ('$nickname', '$content')";

	$result = $conn->query($addSQL);
	if (!$result) {
		die('Failed to add comment' . $conn->error);
	}	
	echo 'Successfully add comment';
	header('Location: ./index.php');
?>