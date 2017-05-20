<?php 
//check request fields from front-end
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	foreach ($_POST as $key => $value) {
		$_POST[$key] = htmlspecialchars(stripslashes(trim($_POST[$key]))); 
		if (empty($_POST[$key])) {
			echo json_encode(array("bad"));
			die();
		}
	}
} else {
	die();
	echo 'bad';
}
require_once '../db/db_connect.php';

$get_event = "SELECT * from Events WHERE id_event='{$_POST['id']}'";
$get_event = $db->prepare($get_event);
// print_r($get_event->errorInfo());

$get_event->execute();
$result = $get_event->fetch(PDO::FETCH_ASSOC);
$result['date_start'] = str_replace(" ", "T", $result['date_start']);
$result['date_end'] = str_replace(" ", "T", $result['date_end']);
$db = null;
?>

<div class="updateEvent-block">
	<form class="form-signin" id="updateEventForm">
		<h2 class="form-signin-heading">Update event</h2>
		<input type="text" id="inputIdEvent" hidden  class="form-control" value="<?php print_r($_POST['id']); ?>" required>
		<input type="text" id="inputIdAuthor" hidden  class="form-control" value="<?php print_r($result['id_author']); ?>" required>

		<input type="text" id="inputName" class="form-control" placeholder="Name" value="<?php print_r($result['name']); ?>" required>
		<textarea name="desc" id="inputDesc" class="form-control" placeholder="Description" required><?php print_r($result['description']); ?></textarea>
		<div class="row">
			<label for="example-date-input" class="col-12 col-form-label">Date start</label>
			<div class="col-12">
				<input class="form-control" id="dateStart" type="datetime-local" value="<?php print_r($result['date_start']); ?>" required>
			</div>
		</div>
		<div class="row">
			<label for="example-date-input" class="col-12 col-form-label">Date end</label>
			<div class="col-12">
				<input class="form-control" id="dateEnd" type="datetime-local" value="<?php print_r($result['date_end']); ?>" required>
			</div>
		</div>
		<div class="row">
			<label for="example-color-input" class="col-12 col-form-label">Color</label>
			<div class="col-12">
				<input class="form-control" id="color" type="color" value="<?php print_r($result['color']); ?>" required>
			</div>
		</div>
		<button class="btn btn-lg btn-primary btn-block">updateEvent</button>
		<div class="result-updateEvent text-center"><a class='close-link'>Close</a></div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#updateEventForm button").on("click", function(event) {
			var id_event = $("input#inputIdEvent").val();
			var id_author = $("input#inputIdAuthor").val();
			var name = $("input#inputName").val();
			var description	 = $("#inputDesc").val();
			var date_start = $("input#dateStart").val();
			var date_end = $("input#dateEnd").val();
			var color = $("input#color").val();

			event.preventDefault();
			$.ajax({
				url: "/db/updateEvent_todb.php",
				type: "post",
				data: {
					id_event : id_event,  
					id_author : id_author,  
					name : name,  
					description : description,  
					date_start : date_start,  
					date_end : date_end, 
					color : color
				}
			})
			.done(function(data) {
				if (data == "good") {
					$(".result-updateEvent").html("Successful, <a href='/' class='close-link'>Close form</a>");
					$('#calendar').fullCalendar( 'refetchEvents');
				} else {
					$(".result-updateEvent").html("Error, try again.");
				}
			});
		});
	});
</script>
