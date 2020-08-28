<?php
	session_start();
	$_SESSION["username"] = '';
	$_SESSION['privilege_type'] = '';
	session_destroy();
?>