<?php
include('includes/config.php');
include('includes/db.php');
error_reporting(0);
if (isset($_POST['submit'])) {
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$citizenship = $_POST['citizenship'];
	$contactno = $_POST['contactno'];
	$status = 1;
	$query = mysqli_query($bd, "insert into users(fullName,userEmail,password,citizenshipNo,contactNo,status) values('$fullname','$email','$password','$citizenship','$contactno','$status')");
	$msg = "Registration successfull. Now You can login !";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Dashboard">
	<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

	<title>CMS | User Registration</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/style-responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/user-register.css" />
	<script>
		function userAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url: "check_availability.php",
				data: 'email=' + $("#email").val(),
				type: "POST",
				success: function(data) {
					$("#user-availability-status1").html(data);
					$("#loaderIcon").hide();
				},
				error: function() {}
			});
		}
	</script>
</head>

<body>
	<div id="login-page">
		<div class="container">

			<form class="form-login" method="post">
				<h2 class="form-login-heading">User Registration</h2>
				<p style="padding-left: 1%; color: green">
					<?php if ($msg) {
						echo htmlentities($msg);
					} ?>


				</p>
				<div class="login-wrap">
					<input type="text" class="form-control" placeholder="Full Name" name="fullname" required="required" autofocus>
					<br>
					<input type="email" class="form-control" placeholder="Email" id="email" onBlur="userAvailability()" name="email" required="required">
					<span id="user-availability-status1" style="font-size:12px;"></span>
					<br>
					<input type="password" class="form-control" placeholder="Password" required="required" name="password"><br>
					<br>
					<input type="text" class="form-control" placeholder="Citizenship No." required="required" name="citizenship"><br>
					<input type="text" class="form-control" maxlength="10" name="contactno" placeholder="Contact no" required="required" autofocus>
					<br>


					<br>
					<!-- <p>Select University</p> -->
					<!-- <select class="form-control" name="university"> -->
					<?php

					// $sql = "SELECT * FROM `university`";
					// $result = $conn->query($sql);

					// if ($result->num_rows > 0) {
					// 	// output data of each row
					// 	while ($row = $result->fetch_assoc()) {

					// 	}
					// }

					?>

					</select>
					<br>

					<button class="btn btn-theme btn-block" type="submit" name="submit" id="submit"><i class="fa fa-user"></i> Register</button>
					<hr>

					<div class="registration">
						Already Registered<br />
						<a class="" href="index.php">
							Sign in
						</a>
					</div>

				</div>



			</form>

		</div>
	</div>

	<!-- js placed at the end of the document so the pages load faster -->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!--BACKSTRETCH-->
	<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
	<script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>



</body>

</html>