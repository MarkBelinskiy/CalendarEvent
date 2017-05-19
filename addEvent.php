<div class="addEvent-block">
	<form class="form-signin" id="addEventForm">
		<h2 class="form-signin-heading">Add new event</h2>
		<input type="text" id="inputIdAuthor" hidden class="form-control" value="<?php print_r($_COOKIE['id_author']); ?>" required>

		<input type="text" id="inputName" class="form-control" placeholder="Name" value="" required>
		<textarea name="desc" id="inputDesc" class="form-control" placeholder="Description" value="" required></textarea>
		<div class="row">
			<label for="example-date-input" class="col-12 col-form-label">Date start</label>
			<div class="col-12">
				<input class="form-control" id="dateStart" type="datetime-local" value="" required>
			</div>
		</div>
		<div class="row">
			<label for="example-date-input" class="col-12 col-form-label">Date end</label>
			<div class="col-12">
				<input class="form-control" id="dateEnd" type="datetime-local" value="" required>
			</div>
		</div>
		<div class="row">
			<label for="example-color-input" class="col-12 col-form-label">Color</label>
			<div class="col-12">
				<input class="form-control" id="color" type="color" required>
			</div>
		</div>
		<button class="btn btn-lg btn-primary btn-block">addEvent</button>
		<div class="result-addEvent text-center"><a class='close-link'>Close</a></div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#addEventForm button").on("click", function(event) {
			var id_author = $("input#inputIdAuthor").val();
			var name = $("input#inputName").val();
			var description	 = $("#inputDesc").val();
			var date_start = $("input#dateStart").val();
			var date_end = $("input#dateEnd").val();
			var color = $("input#color").val();

			event.preventDefault();
			$.ajax({
				url: "/db/addEvent_todb.php",
				type: "post",
				data: {
					id_author : id_author,  
					name : name,  
					description : description,  
					date_start : date_start,  
					date_end : date_end, 
					color : color
				}
			})
			.done(function(data) {
				console.log(data);
				if (data == "good") {
					$(".result-addEvent").html("Successful, <a href='/' class='close-link'>Close form</a>");
					$('#calendar').fullCalendar( 'refetchEvents');
				} else {
					$(".result-addEvent").html("Error, try again.");
				}
			});
		});
	});
</script>
