<?php
	require_once('conn.php');
	function getNicknameByUsername($username) {
		global $conn;
		$getNicknameSQL = "SELECT nickname from jaredWu0805_users WHERE username=?";
		$stmt = $conn->prepare($getNicknameSQL);
		$stmt->bind_param('s', $username);

		if(!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$nicknameResult = $stmt->get_result();
		if ($row = $nicknameResult->fetch_assoc()) {
			$nickname = $row['nickname'];
		}
		return $nickname;
	}

	function getPrivilegeByUsername($username) {
		global $conn;
		$getPrivilegeSQL = "SELECT privilege_type from jaredWu0805_users WHERE username=? ";
		$stmt = $conn->prepare($getPrivilegeSQL);
		$stmt->bind_param('s', $username);

		if(!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$privilegeResult = $stmt->get_result();
		if ($row = $privilegeResult->fetch_assoc()) {
			$privilege = $row['privilege_type'];
		}
		return $privilege;
	}

	function escape($str) {
		return htmlspecialchars($str, ENT_QUOTES);
	}

	function getUserDataByUsername($username) {
		global $conn;
		$selectSQL = "SELECT * FROM jaredWu0805_users WHERE username=?";

		$stmt = $conn->prepare($selectSQL);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		return $stmt->get_result();
	}

	function checkPrivilege($username) {
		$privilege_type = getPrivilegeByUsername($username);
	
		if ($privilege_type !== 'admin') {
			header('Location: ./admin_login.php?errCode=5');
			die('使用者沒有權限');		
		}
	}
?>