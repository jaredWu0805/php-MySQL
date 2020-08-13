<?php
	session_start();
	require_once('conn.php');

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (empty($username) || empty($password)) {
		header('Location: ./login.php?errCode=1');
		die('欄位不能為空白');	
	}

	$selectSQL = sprintf( 
		"SELECT * FROM users WHERE username='%s' and password='%s'",
		$username,
		$password
	);

	$result = $conn->query($selectSQL);

	if (!$result){
		die('Failed to login<br>' . $conn->error);
	} 
	
	if ($result->num_rows){
		echo 'Successfully login';
		$_SESSION['username'] = $username;
		header('Location: ./index.php');		
	} else {
		header('Location: ./login.php?errCode=3');
		die('使用者名稱或密碼有錯');
	}
	
?>

