<?php
	session_start();
	require_once('conn.php');

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (empty($username) || empty($password)) {
		header('Location: ./login.php?errCode=1');
		die('欄位不能為空白');	
	}

	$selectSQL = "SELECT * FROM jaredWu0805_users WHERE username=?";

	$stmt = $conn->prepare($selectSQL);
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!$result){
		die('Failed to login<br>' . $conn->error);
	} 
	$row = $result->fetch_assoc();
	if (password_verify($password, $row['password'])) {
		echo 'Successfully login';
		$_SESSION['username'] = $username;
		header('Location: ./index.php');		
		exit();
	}
	header('Location: ./login.php?errCode=3');
	die('使用者名稱或密碼有錯');
?>

