<?php
	require_once('conn.php');
	session_start();
	$nickname= trim($_POST['nickname']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (empty($nickname) || empty($username) || empty($password)) {
		header('Location: ./register.php?errCode=1');
		die('欄位不能為空白');	
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	// check if username exists
	$stmt = $conn->prepare("SELECT * FROM jaredWu0805_users WHERE username=?");
	$stmt->bind_param('s', $username);
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$mysqlGetUsers = $stmt->get_result();

	while($row = $mysqlGetUsers->fetch_assoc()){
		header('Location: ./register.php?errCode=2');
		die('使用者名稱已被註冊');
	}

	// register user
	$stmt = $conn->prepare("INSERT INTO jaredWu0805_users (nickname, username, password) 
		VALUES (?, ?, ?)");
	$stmt->bind_param('sss', $nickname, $username, $password);
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result = $stmt->affected_rows;
	if (!$result) {
		die('Failed to add user<br>' . $conn->error);
	}	
	echo 'Successfully add user';
	header('Location: ./index.php');
	$_SESSION['username'] = $username;
?>

