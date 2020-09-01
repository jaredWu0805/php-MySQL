<?php
	require_once('./conn.php');
	session_start();
	header('Content-type:application/json;charset=utf-8');		

	if (!empty($_SESSION['privilege_type']) && !empty($_SESSION['username'])) {
		header('Location: ./index.html');
		die();
	}

	if (empty($_POST['username']) || empty($_POST['password'])) {
		return_res("使用者和密碼不能為空");
		die();
	}

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = 'SELECT * FROM jaredWu0805_blog_users WHERE username=?';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $username);
	$stmt->execute();

	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	
	if (!empty($row) && hash('sha256', $password) === $row['password']) {
		if ($row['privilege_type'] !== 'admin') {
			return_res("使用者沒有權限");
			die();		
		}
		$_SESSION['username'] = $username;
		$_SESSION['privilege_type'] = $row['privilege_type'];
		return_res(true);
		die();
	} else {
		return_res("帳號或密碼錯誤");
		die();		
	}
	

	function return_res($str) {
		$json = array();
		array_push($json, array(
			"msg" => $str
		));
		$response = json_encode($json);
		echo $response;
	}
?>