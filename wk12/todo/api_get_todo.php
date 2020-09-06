<?php
	require_once("conn.php");

	
	if (empty($_GET['id'])) {
		$data = array(
			"success" => false,
			"msg" => "New todo list");
		send_res($data);
	}

	$id = $_GET['id'];
	$sql = "SELECT * FROM jaredWu0805_todos WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$result = $stmt->execute();

	if (!$result) {
		$data = array(
			"success" => false,
			"message" => "conn error" . $conn->error
		);
		send_res($data);
	}

	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	if ($row === null) {
		$success = false;
		$msg = "List id doesn't exist. Will create new list.";
		$content = "";
	} else {
		$success = true;
		$msg = "Successfully load the list.";
		$content = $row['content'];
	}

	$data = array(
		"success" => $success,
		"msg" => $msg,
		"content" => $content,
	);
	send_res($data);

	function send_res($json){
		$response = json_encode($json);
		echo $response;
		die();
	}
?>