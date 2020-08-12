<?php
	require_once('conn.php');

	// MySql select method
	$result = $conn->query("select * from usertable;");
	if (!$result) {
		die($conn->error);
	}

	while($row = $result->fetch_assoc()){
		echo '<br>username: ' . $row['username'];
		echo '<br>id: ' . $row['id'];
		echo ' <a href="delete.php?username=' . $row['username'] . '">刪除</a>';
	}
	

?>

<h2> add user </h2>
<form method="POST" action="add.php">
	name: <input name="username" />
	<input type="submit" />
</form>


<h2> update user </h2>
<form method="POST" action="update.php">
	name: <input name="username" />
	id: <input name="id" />
	<input type="submit" />
</form>

