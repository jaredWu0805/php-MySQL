<?php
	require_once('conn.php');
	header('Content-type:application/json;charset=utf-8');

	if (empty($_POST['site_name'])) {
		$data = array(
			"success" => false,
			"message" => "Please specify the site_name parameter"
		);
		send_res($data);
	}

	$limit = 5;

	if (!empty($_POST['limit'])) {
		$limit = $_POST['limit'];
	}

	$site_name = $_POST['site_name'];

	if (!empty($_POST['cursor'])) {
		$cursor = $_POST['cursor'];
		$sql = "SELECT id, nickname, content, created_at FROM jaredWu0805_new_board WHERE site_name=? AND id < ? ORDER BY id DESC LIMIT ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sii', $site_name, $cursor, $limit);
	} else {
		$sql = "SELECT id, nickname, content, created_at FROM jaredWu0805_new_board WHERE site_name=? ORDER BY id DESC LIMIT ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('si', $site_name, $limit);
	}

	

	$result = $stmt->execute();
	if (!$result) {
		$data = array(
			"success" => false,
			"message" => "conn error" . $conn->error
		);
		send_res($data);
	}

	
	$last_id = -1;

	$posts = array();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()){
		array_push($posts, array(
			"nickname" => $row['nickname'],
			"content" => $row['content'],
			"created_at" => $row['created_at']
		));
		$last_id = $row['id'];
	}

	// use last_id to check if there is no more post
	
	
	$sql = "SELECT id FROM jaredWu0805_new_board WHERE site_name=? ORDER BY id ASC LIMIT 1";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $site_name);
	$result = $stmt->execute();
	if (!$result) {
		$data = array(
			"success" => false,
			"message" => "conn error" . $conn->error
		);
		send_res($data);
	}

	$no_more = false;

	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()){
		if ($last_id === $row['id'] || $last_id === -1) $no_more = true;
	}

	$res = array(
		"success" => true,
		"cursor" => $last_id,
		"noMoreData" => $no_more,
		"posts" => $posts
	);

	send_res($res);
	
	function send_res($json){
		$response = json_encode($json);
		echo $response;
		die();
	}
?>