<?php foreach ($_POST as $key => $value)
setcookie($key, $value);
?>
<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" >Hello, <?php echo $_POST['name'] ?></a>
	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="account-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
				<div class="dropdown-menu" aria-labelledby="dropdown01">
					<a class="dropdown-item js__update" href="#">Update account information</a>
					<a class="dropdown-item" href="/">Exit</a>
				</div>
			</li>
			<?php if ($_POST['user_group'] == 0): ?>
				<li class="nav-item">
					<a class="nav-link js__invite" href="#">Send invite</a>
				</li>
			<?php else: ?>
				<li class="nav-item">
					<a class="nav-link js__addEvent" href="#">Add event</a>
				</li>
			<?php endif ?>
		</ul>
	</div>
</nav>
