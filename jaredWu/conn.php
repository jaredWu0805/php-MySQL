<?php
	
	$server_name = 'localhost';
	$username = 'Jared';
	$password = '0805';
	$dbname = 'jared';

	$conn = new mysqli($server_name, $username, $password, $dbname);



	if (!empty($conn->connect_error)) {
		die($conn->connect_error . ' ' .
			print_r($conn));
	} 

	$conn->query('SET NAMES UTF8');
	$conn->query('SET time_zone = "+8:00"');
?>


