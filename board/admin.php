<?php
	session_start();
	require_once('utils.php');
	
	$username = $_SESSION['username'];
	checkPrivilege($username);
?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<title>管理頁面</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header>注意!本站為練習用網站，並未實作資安的部分，請勿輸入任何真實的帳號與密碼</header>
	<div class="container">
		<section class="admin__section">
			<div class="login__btns">
				
				<a class="return__btn" href="./index.php">留言板</a>
				<a class="logout__btn" href="./logout.php">登出</a>
			</div>
			<h1>管理頁面</h1>
			<div class='admin__username'> 使用者：<?php echo $username; ?> </div>
			<div class="admin__container">
				<a class="admin__btn" href="./admin_users.php">Users</a>
			</div>
		</section>
	
	</div>

	
</body>
</html>