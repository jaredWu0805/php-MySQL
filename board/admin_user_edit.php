<?php
	require_once('conn.php');	
	require_once('utils.php');
	session_start();
	
	$username = $_SESSION['username'];
	checkPrivilege($username);

	$id = $_GET['id'];
	$selectSQL = "SELECT * FROM jaredWu0805_users WHERE id=?";
	$stmt = $conn->prepare($selectSQL);
	$stmt->bind_param('i',$id);
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
				<a class="return__btn" href="./admin_users.php">返回 Users</a>
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
						<th></th>
					</thead>
						<form method="POST" action="handle_admin_user_edit.php">
							<?php while ($row = $result->fetch_assoc()) {?>
							<tr>
								<td>
									<input name='id' type='hidden' value='<?php echo $row["id"]; ?>'>
									<?php echo $row['id']; ?>
								</td>
								<td>
									<input name='username' type='hidden' value='<?php echo $row["username"]; ?>'>
									<?php echo $row['username']; ?>			
								</td>
								<td>
									<select name='privilege_type'>
										<option value='admin' 
										<?php if($row['privilege_type'] === 'admin') echo 'selected'; ?>>admin</option>
										<option value='normal_user' 
										<?php if($row['privilege_type'] === 'normal_user') echo 'selected'; ?>>normal_user</option>
										<option value='banned' 
										<?php if($row['privilege_type'] === 'banned') echo 'selected'; ?>>banned</option>
									</select>
								</td>
								<td>
									<select name='is_deleted'>
										<?php if (is_null($row['is_deleted'])) {
												$deleted = False;
											} else {
												$deleted = True;
										} ?>

										<option value='True'
										<?php if($deleted == True) echo 'selected'; ?>>True</option>
										<option value='False' 
										<?php if($deleted === False) echo 'selected'; ?>>False</option>
									</select>
								</td>
								<td><?php echo $row['created_at']; ?>
									
								</td>
								<td>
									<button type='submit' class='admin__edit__btn'>Update</button>
								</td>
							</tr>
							<?php } ?>
						</form>
				</table>
			<div>
		</section>
	
	</div>

	
</body>
</html>