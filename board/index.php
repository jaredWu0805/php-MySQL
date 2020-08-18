<?php	
	session_start();
	require_once('conn.php'); 
	require_once('utils.php');
	
	// Get user info from session
	$username = NULL;
	$nickname = NULL;
	
	if (!empty($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$nickname = getNicknameByUsername($username);
	} 	

	// Get comments
	$selectSQL = "SELECT C.content as content, 
		C.created_at as created_at, C.id as id,
		U.username as username, 
		U.nickname as nickname from 
		jaredWu0805_comments as C LEFT JOIN 
		jaredWU0805_users as U ON 
		C.username = U.username ORDER BY 
		created_at DESC";
	$stmt = $conn->prepare($selectSQL);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!$result) die('Cannot get data from DB' . $conn->error);
?>
<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<title>留言板</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header>注意!本站為練習用網站，並未實作資安的部分，請勿輸入任何真實的帳號與密碼</header>
	<div class="container">
		<section class="add__section">
			<div class="login__btns">
				<?php if (!empty($username)) {?>
					<div class='username'> 使用者：<?php echo $username; ?> </div>
					<a class="logout__btn" href="./logout.php">登出</a>
				<?php } else { ?>
					<a class="register__btn" href="./register.php">註冊</a>
					<a class="login__btn" href="./login.php">登入</a>
				<?php } ?>
			</div>
			<h1>留言板</h1>
			<?php
				if (!empty($_GET['errCode'])) {
					$errCode = $_GET['errCode'];
					if ($errCode === '1') {
						echo "<div class='warning'>錯誤：欄位不能為空白</div>";
					}
				}
			?>
			<?php if (!empty($username)) {
					echo "
						<div>Hi ". escape($nickname) ." !
					"; 
				?>
					<button class="edit__nickname__btn">編輯暱稱</button>
				</div>
				<form class="update__form hide" method="POST" action="update_user.php">
					<div><input name="newNickname" placeholder="請輸入您新的暱稱.." required/></div>
					<button class="edit__nickname__btn update">更新</button>
				</form>	
				<form class="general__form" method="POST" action="add_post.php">
					<div class="add__comment">
						<div> 有什麼想說的嗎? </div>
						<div class="text__container"><textarea name="content" rows="6" placeholder="請輸入您的留言.." required></textarea></div>
					</div>
					<?php
						echo "<input type='hidden' name='nickname' value='". escape($nickname) ."'>";
					?>
					<div class="add__btn"><button>送出</button></div>
				</form>	
			<?php } else { ?>
				<div class="desc"> 請先登入帳號</div>
			<?php }?>
		</section>
		<section class="comments">
			<?php
				while($row = $result->fetch_assoc()) {
					echo "
					<div class='comment'>
						<div class='icon'></div>
						<div class='comment__details'>
							<div class='first__row'>
								<div class='nickname'>". escape($row['nickname']) ." (@". escape($row['username']) .")</div>
								<div class='created__at'>。". $row['created_at'] ."</div>
								<div class='btns'>
									<a href='./edit_comment.php?id=". $row['id'] ."' class='edit__btn' title='edit'></a>
									<a href='./delete_comment.php?id=". $row['id'] ."' class='delete__btn' title='delete'></a>
								</div>
							</div>
							<div class='second__row'>
								<div class='comment__content'>". escape($row['content']) ."</div>
							</div>
						</div>
					</div>";
				}
			?>
		</section>
	</div>

<script>
	var update_btn = document.querySelector('.edit__nickname__btn');
	update_btn.addEventListener('click', function() {
		var form = document.querySelector('.update__form');
		form.classList.toggle('hide');
	});

</script>
</body>
</html>
