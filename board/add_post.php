<?php
	session_start();
	require_once('conn.php');

	$username = $_SESSION['username'];
	$content = trim($_POST['content']);

	if (empty($username) || empty($content)) {
		header('Location: ./index.php?errCode=1');
		die('欄位不能為空白');	
	}

	$addSQL = "INSERT INTO jaredWu0805_comments (username, content) 
		VALUES (?, ?)";

	$stmt = $conn->prepare($addSQL);
	$stmt->bind_param('ss', $username, $content);

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result = $stmt->affected_rows;
	if (!$result) {
		die('Failed to add user<br>' . $conn->error);
	}	
	echo 'Successfully add comment';
	header('Location: index.php');
?>

