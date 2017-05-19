<div class="update-block">
	<form class="form-signin" id="updateForm">
		<h2 class="form-signin-heading">Update information</h2>
		<input type="text" id="inputName" class="form-control" placeholder="Name" value="<?php print_r($_COOKIE['name']); ?>" required>
		<input type="email" id="inputEmail" class="form-control" value="<?php print_r($_COOKIE['email']); ?>" placeholder="Email address" required autofocus>
		<label for="inputPassword" class="sr-only" >Password</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" value="<?php print_r($_COOKIE['password']); ?>" required>
		<button class="btn btn-lg btn-primary btn-block" >Update</button>
	</form>
	<div class="result-update text-center"><a class='close-link'>Close</a></div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#updateForm button").on("click", function(event) {
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
					$(".result-update").html("Successful, <a href='/' class='close-link'>Close form</a>");
				} else {
					$(".result-update").html("Error, try again.");
				}
			});
		});
	});
</script>