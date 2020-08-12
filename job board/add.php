<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<title>Job board 職缺報報 管理後台</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="container">
		<h1>Job board 職缺報報 管理後臺</h1>
		<a href="./admin.php">回到管理業</a>
		<div class="jobs">
		<form method="POST" action="add_SQL.php">
			<div>職缺名稱：<input name='title' /></div>
			<div>職缺描述：<textarea name='description' rows='10'></textarea></div>
			<div>薪資範圍：<input name='salary' /></div>
			<div>職缺連結：<input name='link' /></div>
			<input type='submit' value='送出'/>
		</form>	
	</div>
</body>
</html>