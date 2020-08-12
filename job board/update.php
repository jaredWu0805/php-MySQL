<?php require_once('conn.php'); ?>

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
		<?php
			$id = $_GET['id'];
			$sql = 'SELECT * from jobs WHERE id=' . $_GET['id'];
			$result = $conn->query($sql);
			if ($result) {
				while($row = $result->fetch_assoc()) {
					echo '
					<form method="POST" action="update_sql.php">
						<div>職缺名稱：<input name="title" value="'. $row["title"] .'"/></div>
						<div>職缺描述：<textarea name="description" rows="10" 
						>'. $row["description"] .'</textarea></div>
						<div>薪資範圍：<input name="salary" value="'. $row["salary"] .'"/></div>
						<div>職缺連結：<input name="link" value="'. $row["link"] .'"/></div>
						<input type="submit" value="更改"/>
						<input type="hidden" name="id" value="'. $id .'">
					</form>
					';
				}
			} else {
				die('Get error' . $conn->error);
			}
		?>
				
	</div>
</body>
</html>