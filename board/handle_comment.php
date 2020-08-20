<?php
	require_once('conn.php');

	$id = $_POST['id'];
	$content = trim($_POST['content']);
	if (empty($content)) {
		header('Location: ./update_comment.php?errCode=1&id='.$id);
		die('欄位不能為空白');
	}

	$sql = "UPDATE jaredWu0805_comments SET content=? WHERE id=?";

	$stmt = $conn->prepare($sql);
	$stmt->bind_param('si', $content, $id);

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	echo 'Successfully update comment';
	header('Location: ./index.php');

?>