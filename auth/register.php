<?php 
if ($_GET['email']) {
	require_once '../db/db_connect.php';
	$check_reg = "SELECT * from Authors WHERE email='{$_GET['email']}'";
	$check_reg = $db->prepare($check_reg);
	$check_reg->execute();

	$result = $check_reg->fetch(PDO::FETCH_ASSOC);
	$db = null;
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Registration</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
</head>

<body>
	<div class="container">
		<?php if ($result):	?>
			<form class="form-signin" id="registerForm">
				<h2 class="form-signin-heading">Registration</h2>
				<input type="text" id="inputName" class="form-control" placeholder="Name" required>
				<input type="email" id="inputEmail" class="form-control" value="<?php print_r($_GET['email']); ?>" disabled placeholder="Email address" required autofocus>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
				<button class="btn btn-lg btn-primary btn-block" >Register</button>
			</form>
			<div class="result-register text-center"></div>
		<?php else: ?>
			<h2 class="form-signin-heading">We don't need you :)</h2>
		<?php endif ?>

	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#registerForm button").on("click", function(event) {
				var name = $("input#inputName").val();
				var email = $("input#inputEmail").val();
				var password = $("input#inputPassword").val();

				event.preventDefault();
				$.ajax({
					url: "/auth/updateUser.php",
					type: "post",
					data:  {name: name, email: email, password: password}
				})
				.done(function(data) {
					if (data == "good") {
						$(".result-register").html("Successful, <a href='/'>Enter to the calendar</a>");
						$('#registerForm').addClass('dn');
					} else {
						$(".result-register").html("Error, try again.");
					}
					
				});
			});
		}); 
	</script>
	<!-- /container -->
</body>

</html>
