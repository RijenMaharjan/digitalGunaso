<?php
session_start();
error_reporting(0);
include("include/config.php");

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password']; // Encrypt the password to match the stored one
	// var_dump($username);
	// var_dump(md5($password));
	$pw = md5($password);
	$query = "SELECT * FROM admin WHERE username='$username' AND password='$pw'";
	// echo $query;
	$result = mysqli_query($bd, $query);
	// print_r($result);
	// exit;
	// echo $result;
	if (mysqli_num_rows($result) > 0) {
		// Successful login
		$_SESSION['alogin'] = $username;
		$_SESSION['id'] = mysqli_fetch_assoc($result)['id']; // Store admin ID in session
		header("Location: dashboard.php");
		exit();
	} else {
		var_dump($username);
		var_dump($password);
		// Login failed
		$_SESSION['errmsg'] = "Invalid $username or $pw";
		header("Location: index.php");
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Login</title>
	<!-- <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link href="assets/css/admin-login.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
</head>

<body>

	<!-- <div class="wrapper">
		<div class="container"> -->
	<div class="login-container">
		<div class="login-box">
			<div class="row">
				<form class="module-login span4 offset4" method="post">
					<h3 class="text-center">Admin Login</h3>
					<!-- Error message -->
					<span style="color:red;"><?php echo htmlentities($_SESSION['errmsg']);
																		$_SESSION['errmsg'] = ""; ?></span>

					<!-- Username -->
					<div class="form-group">
						<label for="username">Username</label>
						<input id="username" class="form-control" type="text" name="username" placeholder="Enter username" required>
					</div>

					<!-- Password -->
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" class="form-control" type="password" name="password" placeholder="Enter password" required>
					</div>

					<!-- Submit button -->
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary" name="submit">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="scripts/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>