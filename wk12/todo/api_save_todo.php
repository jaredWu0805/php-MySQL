<?php
	require_once("conn.php");

	
	if (empty($_POST['content'])) {
		$data = array(
			"Save success" => false,
			"msg" => "Todo list is empty");
		send_res($data);
	}

	$id = '';
	if (!empty($_POST['id'])) {
		$id = $_POST['id'];
		$sql = "UPDATE jaredWu0805_todos SET content=? WHERE id=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('si', $_POST['content'], $id);
		$result = $stmt->execute();
	} else {
		$sql = "INSERT INTO jaredWu0805_todos (content) VALUES (?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $_POST['content']);
		$result = $stmt->execute();
		$id = $conn->insert_id;
	}

	
	if (!$result) {
		$data = array(
			"success" => false,
			"message" => "conn error" . $conn->error
		);
		send_res($data);
	}

	$data = array(
		"Save success" => true,
		"msg" => "Successfully save todo list. Your id is " . $id,
		"id" => $id);
	send_res($data);
	

	function send_res($json){
		$response = json_encode($json);
		echo $response;
		die();
	}
?>