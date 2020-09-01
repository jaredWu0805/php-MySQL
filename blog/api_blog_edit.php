<?php
	require_once('./conn.php');
	session_start();
	// check privilege first

	if (empty($_SESSION['privilege_type']) || 
		$_SESSION['privilege_type'] !== 'admin') {
		echo "Not a valid user";
		header('Location: ./index.html');
		exit();
	}

	if (empty($_POST['new_title'])) {
		header('Location: ./blog_edit.html?id=' . $_POST['id']);
		exit();
	}

	$title = $_POST['new_title'];
	$category = $_POST['category'];
	$content = $_POST['blog_content'];
	$id = $_POST['id'];

	$sql = 'UPDATE jaredWu0805_blogs SET title=?, category=?, blog=? WHERE id=?';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ssss', $title, $category, $content, $id);
	$stmt->execute();
	$result = $stmt->get_result();

	header('Location: ./admin.html');
?>