<?php
	require_once('conn.php');

	$nickname= trim($_POST['nickname']);
	$content = trim($_POST['content']);

	if (empty($nickname) || empty($content)) {
		header('Location: ./index.php?errCode=1');
		die('欄位不能為空白');	
	}

	$content = $conn->real_escape_string($content);

	$addSQL = sprintf(
		"INSERT INTO comments (nickname, content) 
		VALUES ('%s', ' %s ')",
		$nickname,
		$content
	);

	$result = $conn->query($addSQL);
	if (!$result) {
		die('Failed to add comment<br>' .$conn->error);
	}	
	echo 'Successfully add comment';
	header('Location: ./index.php');
?>

