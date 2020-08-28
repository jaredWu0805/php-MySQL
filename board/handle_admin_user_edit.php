<?php
	require_once('conn.php');
	require_once('utils.php');
	session_start();

	$username = $_SESSION['username'];
	checkPrivilege($username);

	$id = $_POST['id'];
	$username = trim($_POST['username']);
	$privilege_type = $_POST['privilege_type'];
	if ($_POST['is_deleted'] === 'True') {
		$is_deleted = 1;
	} else {
		$is_deleted = null;
	}

	echo $is_deleted;
	echo $privilege_type;
	echo $username;

	$sql = "UPDATE jaredWu0805_users SET privilege_type=?, is_deleted=? WHERE id=?";

	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ssi', $privilege_type, $is_deleted, $id);

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	header('Location: ./admin_users.php');
?>