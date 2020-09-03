<?php
	require_once('conn.php');
	header('Content-type:application/json;charset=utf-8');
	

	if (empty($_POST['site_name']) ||
		empty($_POST['nickname']) ||
		empty($_POST['content'])) {
		$data = array(
			"success" => false,
			"message" => "Missing fields, please fill in all inputs"
		);
		send_res($data);
	}

	$site_name = $_POST['site_name'];
	$nickname = $_POST['nickname'];
	$content = $_POST['content'];

	$sql = "INSERT INTO jaredWu0805_new_board (site_name, nickname, content) VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sss', $site_name, $nickname, $content);
	$result = $stmt->execute();
	if (!$result) {
		$data = array(
			"success" => false,
			"message" => "conn error" . $conn->error
		);
		send_res($data);
	}

	$data = array(
		"success" => true,
		"message" => "Successfully add the comment"
	);
	send_res($data);
	
	function send_res($json){
		$response = json_encode($json);
		echo $response;
		die();
	}
?>