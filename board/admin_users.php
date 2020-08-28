<?php
	session_start();
	require_once('utils.php');
	require_once('conn.php');
	
	$username = $_SESSION['username'];
	checkPrivilege($username);

	$selectSQL = "SELECT * FROM jaredWu0805_users";
	$stmt = $conn->prepare($selectSQL);
	$stmt->execute();
	$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<title>管理頁面 - Users</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header>注意!本站為練習用網站，並未實作資安的部分，請勿輸入任何真實的帳號與密碼</header>
	<div class="container">
		<section class="admin__section">
			<div class="login__btns">

				<a class="return__btn" href="./admin.php">返回主管理頁面</a>
				<a class="return__btn" href="./index.php">留言板</a>
				<a class="logout__btn" href="./logout.php">登出</a>
			</div>
			<h1>管理頁面</h1>
			<div class='admin__username'> 使用者：<?php echo $username; ?> </div>
			<div class="admin__container">
				<div>Users</div>
			</div>
			<div class="table__container">
				<table class="admin__users">
					<thead>
						<th>Id</th>
						<th>Username</th>
						<th>Privilege Type</th>
						<th>Is deleted</th>
						<th>Created at</th>
						<th>Edit user</th>
					</thead>
						<?php while ($row = $result->fetch_assoc()) {?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['privilege_type']; ?></td>
							<td><?php 
							if (is_null($row['is_deleted'])) {
								echo 'False';}
								else {
									echo 'True';
								} ?></td>
							<td><?php echo $row['created_at']; ?></td>
							<td><a class="admin__edit__btn" href="./admin_user_edit.php?id=<?php echo $row['id']; ?>">Edit</a></td>
						<tr>
						<?php } ?>
				</table>
			<div>
		</section>
	
	</div>

	
</body>
</html>