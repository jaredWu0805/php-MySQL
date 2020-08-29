<?php
	session_start();
	header('Content-type: application/json; charset=utf-8;');

	$json = array();
	if (!empty($_SESSION['privilege_type']) && 
		$_SESSION['privilege_type'] === 'admin') {
		array_push($json, array(
			"admin"=> true));
	} else {
		array_push($json, array(
		"admin"=> false));
	} 

	$response = json_encode($json);

	echo $response;
?>