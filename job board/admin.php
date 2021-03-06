<?php	require_once('conn.php'); ?>

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
		<a class="add__link" href="./add.php">新增職缺</a>
		<div class="jobs">
			<?php
				$sql = 'SELECT * from jobs ORDER BY created_at DESC';
				$result = $conn->query($sql);
				if (!$result) die($conn->error);		
				while($row = $result->fetch_assoc()) {
					echo 
					'<div class="job">
						<h2 class="job__title">' . $row['title'] . '</h2>
						<p class="job__desc">' . $row['description'] . '</p>
						<p class="job__salary">'. $row['salary'] .'</p>
						<a class="job__link" href="update.php?id='. $row['id'] .'">編輯職缺</a>
						<a class="job__link" href="./delete.php?id='. $row['id'] .'">刪除職缺</a>
					</div>'; 
				}
			?>
		</div>			
	</div>
</body>
</html>