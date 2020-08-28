<?php
	session_start();
	require_once('conn.php');
	require_once('utils.php');
	$id = $_GET['id'];
	$username = $_SESSION['username'];

	if (empty($username) || empty($id)) {
		header('Location: ./index.php?errCode=4');
		die('沒有權限編輯或刪除');
	}

	$privilege_type = getPrivilegeByUsername($username);

	$sql = "SELECT * FROM jaredWu0805_comments WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();

	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	if ($username !== $row['username'] && $privilege_type !== 'admin') {
		header('Location: ./index.php?errCode=4');
		die('沒有權限編輯或刪除');
	}

	$delSQL = "UPDATE jaredWu0805_comments SET is_deleted=1 WHERE id=?";
	$stmt = $conn->prepare($delSQL);
	$stmt->bind_param('i', $id);
	
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result = $stmt->affected_rows;

	if (!$result) die('Delete failed' . $conn->error);

	header('Location: ./index.php');
?>

	