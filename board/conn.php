<?php
	$server_name = 'mentor-program.co';
	$username = 'mtr04group4';
	$password = 'Lidemymtr04group4';
	$db_name = 'mtr04group4';

	$conn = new mysqli($server_name, $username, $password, $db_name);

	if ($conn->connect_error) {
		die("connection failed: " . $conn->connect_error);
	}

	$conn->query('SET NAMES UTF8');
	$conn->query('SET time_zone = "+8:00"');
	
?>