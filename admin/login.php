<?php
	if(isset($_POST['username']) && isset($_POST['password'])){
		ob_start();
		session_start();
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		global $g_db;
		$result = $g_db->query("SELECT * FROM users WHERE username='$username'",array());
		
		if(empty($result)){
			// Retry logging in
			header('Location: http://hopper.wlu.ca/~rodu4140/test/admin/');
			exit();
		}
		$id   = $result[0]['id'];
		$user = $result[0]['username'];
		$pass = $result[0]['password'];
		$salt = $result[0]['salt'];

		$check = check_password($password, $salt, $pass);
		
		if(!$check){
			header('Location: http://hopper.wlu.ca/~rodu4140/test/admin/');
			exit();
		}
		
		session_regenerate_id();
		$_SESSION['sess_user_id']  = $id;
		$_SESSION['sess_username'] = $username;
		session_write_close();
		header('Location: http://hopper.wlu.ca/~rodu4140/test/admin/');
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>
</head>
 
<body>
<form id="form1" name="form1" method="post" action="?action=submit">
	<table width="510" border="0" align="center">
		<tr>
			<td colspan="2">Login Form</td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" id="username" /></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" id="password" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="button" id="button" value="Submit" /></td>
		</tr>
	</table>
</form>
</body>
</html>