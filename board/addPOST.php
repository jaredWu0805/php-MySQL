<html style="white-space: pre">
<?php
	require_once('conn.php');

	$nickname= trim($_POST['nickname']);
	$content = trim($_POST['content']);

	if (empty($nickname) || empty($content)) {
		header('Location: ./index.php?errCode=1');
		die('欄位不能為空白');	
	}

	$addSQL = "INSERT INTO comments (nickname, content) VALUES ('$nickname', '$content')";

	$result = $conn->query($addSQL);
	if (!$result) {
		die('Failed to add comment' . $conn->error);
	}	
	echo 'Successfully add comment';
	header('Location: ./index.php');
?>

