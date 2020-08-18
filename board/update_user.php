<?php
	require_once('conn.php');
	session_start();

	$nickname = trim($_POST['newNickname']);
	$username = $_SESSION['username'];
	if (empty($nickname)) {
		header('Location: ./index.php?errCode=1');
		die('欄位不能為空白');
	}

	$sql = "UPDATE jaredWu0805_users SET nickname=? WHERE username=?";

	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $nickname, $username);

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	$result = $stmt->affected_rows;
	if (!$result) {
		die('Failed to add user<br>' . $conn->error);
	}	
	echo 'Successfully update nickname';
	header('Location: ./index.php');
?>