<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<title>登入管理頁面</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header>注意!本站為練習用網站，並未實作資安的部分，請勿輸入任何真實的帳號與密碼</header>
	<div class="container">
		<section class="add__section">
			<div class="login__btns">
				<a class="return__btn" href="./index.php">返回留言板</a>
			</div>
			<h1>登入管理頁面</h1>
			<?php
				if (!empty($_GET['errCode'])) {
					$errCode = $_GET['errCode'];
					if ($errCode === '1') {
						echo "<div class='warning'>錯誤：欄位不能為空白</div>";
					} else if ($errCode ==='3') {
						echo "<div class='warning'>錯誤：使用者名稱或密碼有錯</div>";
					} else if ($errCode ==='5') {
						echo "<div class='warning'>錯誤：使用者沒有權限</div>";
					}
				}
			?>
			<form class="general__form" method="POST" action="handle_admin_login.php">
				<div class="add__comment">
					<div class="desc">您的帳號</div>
					<div><input name="username" placeholder="請輸入您的帳號.." required/></div>
					<div class="desc">您的密碼</div>
					<div><input type="password" name="password" placeholder="請輸入您的密碼.." required/></div>
				</div>
				<div class="add__btn"><button>登入</button></div>
			</form>		
		</section>
	
	</div>

	
</body>
</html>