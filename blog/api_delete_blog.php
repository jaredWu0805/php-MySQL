<?php
	require_once('./conn.php');
	session_start();
	// check privilege first

	if (empty($_SESSION['privilege_type']) || 
		$_SESSION['privilege_type'] !== 'admin') {
		echo "Not a valid user";
		exit();
	}

	if ($_GET['id'] === null) {
		echo "No blog specified";
		exit();
	}

	$id = $_GET['id'];

	$sql = 'UPDATE jaredWu0805_blogs SET is_deleted=1 WHERE id=?
		';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	header('Location: ./admin.html');
?>