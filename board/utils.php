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


	function escape($str) {
		return htmlspecialchars($str, ENT_QUOTES);
	}
?>