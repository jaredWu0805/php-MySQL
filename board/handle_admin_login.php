<?php
	session_start();
	require_once('conn.php');
	require_once('utils.php');

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (empty($username) || empty($password)) {
		header('Location: ./login.php?errCode=1');
		die('欄位不能為空白');	
	}

	$result = getUserDataByUsername($username);
	if (!$result){
		die('Failed to login<br>' . $conn->error);
	} 
	$row = $result->fetch_assoc();
	if (password_verify($password, $row['password'])) {
		if ($row['privilege_type'] !== 'admin') {
			header('Location: ./admin_login.php?errCode=5');
			die('使用者沒有權限');		
		}
		echo 'Successfully login';
		$_SESSION['username'] = $username;
		header('Location: ./admin.php');		
		exit();
	}
	header('Location: ./admin_login.php?errCode=3');
	die('使用者名稱或密碼有錯');
?>

