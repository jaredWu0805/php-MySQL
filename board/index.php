<?php	
	require_once('conn.php'); 
	$selectSQL = "SELECT * from comments ORDER BY created_at ASC";
	$result = $conn->query($selectSQL);
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
			<h1>留言板</h1>
			<?php
				if (!empty($_GET['errCode'])) {
					$errCode = $_GET['errCode'];
					if ($errCode === '1') {
						echo "<div class='warning'>錯誤：欄位不能為空白</div>";
					}
				}
			?>
			<form method="POST" action="addPost.php">
				<div class="add__comment">
					<div class="desc">您的暱稱</div>
					<div><input name="nickname" placeholder="請輸入您的暱稱.." required/></div>
					<div class="desc"> 有什麼想說的嗎? </div>
					<div><textarea name="content" rows="8" placeholder="請輸入您的留言.." required></textarea></div>
				</div>
				<div class="add__btn"><button>送出</button></div>
			</form>		
		</section>
		<section class="comments">
			<?php
				while($row = $result->fetch_assoc()) {
					echo "
					<div class='comment'>
						<div class='icon'></div>
						<div class='comment__details'>
							<div class='first__row'>
								<div class='nickname'>". $row['nickname'] ."</div>
								<div class='created__at'>。". $row['created_at'] ."</div>
								<div class='btns'>
									<a href='./editComment.php?id=". $row['id'] ."' class='edit__btn' title='edit'></a>
									<a href='./deleteComment.php?id=". $row['id'] ."' class='delete__btn' title='delete'></a>
								</div>
							</div>
							<div class='second__row'>
								<div class='comment__content'>". $row['content'] ."</div>
							</div>
						</div>
					</div>";
				}
			?>
		</section>
	</div>

	
</body>
</html>