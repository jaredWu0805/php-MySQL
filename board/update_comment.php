<?php
	session_start();
	require_once('conn.php');
	require_once('utils.php');
	$id = $_GET['id'];
	$username = $_SESSION['username'];

	if (empty($username) || empty($id)) {
		header('Location: ./index.php?errCode=4');
		die('沒有權限編輯或刪除');
	}

	$privilege_type = getPrivilegeByUsername($username);

	$sql = "SELECT * FROM jaredWu0805_comments WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	if ($username !== $row['username'] && $privilege_type !== 'admin') {
		header('Location: ./index.php?errCode=4');
		die('沒有權限編輯或刪除');
	}
 ?>
 
<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<title>更新留言</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header>注意!本站為練習用網站，並未實作資安的部分，請勿輸入任何真實的帳號與密碼</header>
	<div class="container">
		<section class="add__section">
			<div class="login__btns">
				<a class="return__btn" href="./index.php">返回留言板</a>
			</div>
			<h1>更新留言</h1>
			<?php
				if (!empty($_GET['errCode'])) {
					$errCode = $_GET['errCode'];
					if ($errCode === '1') {
						echo "<div class='warning'>錯誤：欄位不能為空白</div>";
					} 
				}
			?>
			<form class="general__form" method="POST" action="
			handle_comment.php">
				<div class="add__comment">
					<div class="desc">您的留言</div>
					<div class="text__container">
						<textarea name="content" rows="6" required><?php echo $row["content"]; ?>
						</textarea>
						<?php
						echo "<input type='hidden' name='id' value='". $id ."'>";
						?>
					</div>
				</div>
				<div class="add__btn"><button>更新</button></div>
			</form>		
		</section>
	
	</div>
</body>
</html>