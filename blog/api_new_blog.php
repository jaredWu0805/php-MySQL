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
		header('Location: ./new_blog.html');
		exit();
	}

	$title = $_POST['new_title'];
	$category = $_POST['category'];
	$content = $_POST['blog_content'];

	$sql = 'INSERT INTO jaredWu0805_blogs (title, category, blog) values (?,?,?)';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sss', $title, $category, $content);
	$stmt->execute();
	$result = $stmt->get_result();

	header('Location: ./admin.html');
?>