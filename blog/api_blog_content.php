<?php
	require_once('./conn.php');

	$limit = 5;
	$offset = 0;

	if (!empty($_GET['limit'])) {
		$limit = $_GET['limit'];
	}

	if (!empty($_GET['offset'])) {
		$offset = $_GET['offset'];
	}

	$sql = '
		SELECT * FROM jaredWu0805_blogs 
		WHERE is_deleted is NULL 
		ORDER BY created_at DESC
		limit ? offset ?';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ii', $limit, $offset);
	$stmt->execute();
	$result = $stmt->get_result();
	$blogs = array();

	while($row = $result->fetch_assoc()) {
		array_push($blogs, array(
			"id" => $row['id'],
			"title" => $row['title'],
			"blog" => $row['blog'],
			"created_at" => $row['created_at']
		));
	}

	$json = array(
		"blogs" => $blogs,
		"limit" => $limit,
		"offset"=> $offset);

	$response = json_encode($json);
	header('Content-type: application/json; charset=utf-8;');
	echo $response;
?>