<?php
	session_start();
	require_once('conn.php');
	$id = $_GET['id'];
	$username = $_SESSION['username'];

	if (empty($username) || empty($id)) {
		header('Location: ./index.php?errCode=4');
		die('沒有權限編輯或刪除');
	}

	$sql = "SELECT * FROM jaredWu0805_comments WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();

	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	if ($username !== $row['username']) {
		header('Location: ./index.php?errCode=4');
		die('沒有權限編輯或刪除');
	}

	$delSQL = "DELETE FROM jaredWu0805_comments WHERE id=?";
	$stmt = $conn->prepare($delSQL);
	$stmt->bind_param('i', $id);
	
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result = $stmt->affected_rows;

	if (!$result) die('Delete failed' . $conn->error);

	header('Location: ./index.php');
?>

	