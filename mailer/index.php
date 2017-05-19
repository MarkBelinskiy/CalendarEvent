<?php
error_reporting(E_ALL);		
require_once 'sender.php';
$sender = new sender;
if(!empty($_POST['send']))
{
	if(!empty($_POST['to']))
	{
		$message_text = $_POST['to'];
		$message_data = array(
			'to'		=> $_POST['to'],
			'title'		=> $sender->mail_content['title']
			);
		$mailSend = $sender->addToDB($message_data);
		$mailSend = $sender->sendMail($sender->smtp_data, $message_data);
		if($mailSend == 0) {
			echo "Success!";
		} else {
			echo "Fail :(";
		}
	} else {
		die("enter email");
	}
} else {
	//Invite form
	echo '
	<div class="invite-block">
		<form class="form-signin invite" id="inviteForm" action="mailer/index.php" method="post">
			<h2 class="form-signin-heading">Enter email to invite someone</h2>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmailInvite" class="form-control" name="to" placeholder="Email address"  autofocus>
			<button class="btn btn-lg btn-primary btn-block" name="send" value="true" >Invite</button>
			<a class="btn btn-lg btn-primary btn-block close-link">Close</a>
		</form>
		<div class="result-invite"></div>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#inviteForm button").on("click", function(event) {
					var email = $("input#inputEmailInvite").val();
					event.preventDefault();
					$.ajax({
						url: "mailer/index.php",
						type: "post",
						data:  {to: email, send: "true"},
					})
					.done(function(data) {
						$(".main .result-invite").html(data);
					});
				});
			}); 
		</script>
	</div>
	';
}
?>
