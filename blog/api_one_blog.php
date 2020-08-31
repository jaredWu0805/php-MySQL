<?php
	require_once('./conn.php');

	if ($_GET['id'] === null) {
		echo "No blog specified";
		exit();
	}

	$id = $_GET['id'];

	$sql = '
		SELECT * FROM jaredWu0805_blogs 
		WHERE is_deleted is NULL AND id=?';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$blogs = array();

	while($row = $result->fetch_assoc()) {
		array_push($blogs, array(
			"id" => $row['id'],
			"title" => $row['title'],
			"blog" => $row['blog'],
			"created_at" => $row['created_at'],
			"category" => $row['category']
		));
	}

	$json = array(
		"blogs" => $blogs,
	);

	$response = json_encode($json);
	header('Content-type: application/json; charset=utf-8;');
	echo $response;
?>