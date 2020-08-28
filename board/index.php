<?php	
	session_start();
	require_once('conn.php'); 
	require_once('utils.php');
	
	// Get user info from session
	$username = NULL;
	$nickname = NULL;
	$privilege_type = NULL;
	if (!empty($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$nickname = getNicknameByUsername($username);
		$privilege_type = getPrivilegeByUsername($username);
	} 	

	$limit = 5;
	$page = 1;
	if (!empty($_GET['page'])) {
		$page = $_GET['page'];
	}
	$offset = ($page - 1) * $limit;
	
	// Get total
	$countSQL = "SELECT COUNT(*) from 
		jaredWu0805_comments WHERE is_deleted is NULL";
	$result = $conn->query($countSQL);
	$row = $result->fetch_row();
	$total_comments = $row[0];
	$total_page = ceil($total_comments / $limit);
	
	// Get comments
	$selectSQL = "
		SELECT C.content as content, 
		C.created_at as created_at, C.id as id,
		U.username as username, 
		U.nickname as nickname 
		from jaredWu0805_comments as C 
		LEFT JOIN jaredWu0805_users as U 
		ON C.username = U.username 
		WHERE C.is_deleted is NULL
		ORDER BY created_at DESC 
		limit ? offset ?";
	$stmt = $conn->prepare($selectSQL);
	$stmt->bind_param('ii', $limit, $offset);
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
		<div class="admin__btn">
			<?php if (!empty($_SESSION['username'])) { ?>
				<a class="logout__btn" href="./admin.php">登入管理頁面</a>
			<?php } else {?>
				<a class="logout__btn" href="./admin_login.php">登入管理頁面</a>
			<?php } ?>
		</div>
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
					if ($errCode === '4') {
						echo "<div class='warning'>錯誤：沒有權限編輯或刪除</div>";
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
				<?php  if ($privilege_type !== 'banned'){ ?>
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
				    <div class="add__comment">
						<div class="banned__warning"> 您已被停權，無法新增貼文</div>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="desc"> 請先登入帳號</div>
			<?php }?>
		</section>
		<section class="comments">
			<?php while($row = $result->fetch_assoc()) { ?>
					<div class='comment'>
						<div class='icon'></div>
						<div class='comment__details'>
							<div class='first__row'>
								<div class='nickname'><?php echo(escape($row['nickname']) . " (@" . escape($row['username']) . ")"); ?> </div>
								<div class='created__at'><?php echo $row['created_at']; ?></div>
								<?php if ($username === $row['username'] || $privilege_type === 'admin') {?>
									<div class='btns'><a href='./update_comment.php?id=<?php echo $row["id"];?>' class='edit__btn' title='edit'></a>
										<a href='./delete_comment.php?id=<?php  echo $row["id"]; ?>' class='delete__btn' title='delete'></a>
									</div><?php } ?>
							</div>
							<div class='second__row'>
								<div class='comment__content'><?php echo(escape($row['content'])); ?></div>
							</div>
						</div>
					</div>
			<?php } ?>
		</section>
		<section class="page__info">
			<div class="page__details">
				總共有  
				<?php echo $total_comments;?>
				則留言，頁數:
				<?php echo $page;?> / <?php echo $total_page;?>
			</div>
			<div class="page__index">
				<?php 
				if ($page != 1) {?>
					<a href='index.php?page=1'>首頁</a>
					<a href='index.php?page=
				<?php echo ($page - 1);?>'>上一頁</a>
				<?php } ?>
				<?php 
				if ($page != $total_page) {?>
					<a href='index.php?page=
					<?php echo ($page + 1);?>'>下一頁</a>
					<a href='index.php?page=
					<?php echo $total_page;?>'>最後一頁</a>
				<?php }?></div>
			
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
