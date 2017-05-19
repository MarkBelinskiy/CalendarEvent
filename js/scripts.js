$(document).ready(function() {
	// function get cookie value from name
	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
	//options for #sign block
	var options = {
		target: '.main',
		dataType: 'json', // target element(s) to be updated with server response 
		success: processJson // post-submit callback function
	};

	// bind to the form's submit event 
	$('#sign').submit(function() {
		$(this).ajaxSubmit(options);
		return false;
	});

	//calenrar init
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		defaultDate: '2017-05-12',
		editable: true,
		navLinks: true, // can click day/week names to navigate views
		eventLimit: true, // allow "more" link when too many events
		events: {
			url: 'calendar/php/get-events.php', //parse events from DB
			error: function() {
				$('#script-warning').show();
			}
		},
		//event when we start to drag 'event', check rights, if have no them call alert
		eventDragStart: function(event) {
			console.log(event.data);
			if (getCookie('user_group') == "0" || getCookie('id_author') == event.data.id_author) {} else {
				alert("No! It's not your event.");
				$('#calendar').fullCalendar('refetchEvents');
			}
		},
		//event calls when we drop to drag 'event', after that updates DB
		eventDrop: function(event, delta, revertFunc) {
			$.ajax({
					url: 'calendar/update_date.php',
					type: 'post',
					data: {
						id: event.id,
						start: event.start.format(),
						end: event.end.format()
					}
				})
				.done(function(data) {
					// console.log(data);
				});

			$('#calendar').fullCalendar('refetchEvents'); // refresh calendar

		},
		//event starts when starts resizing of the event, check rights, if have no them call alert
		eventResizeStart: function(event) {
			if (getCookie('user_group') == "0" || getCookie('id_author') == event.data.id_author) {} else {
				$('#calendar').fullCalendar('refetchEvents');
				alert("No! It's not your event.");
			}
		},
		//event calls when we end resizing the event, after that updates DB
		eventResize: function(event, delta, revertFunc) {
			$.ajax({
					url: 'calendar/update_date.php',
					type: 'post',
					data: {
						id: event.id,
						start: event.start.format(),
						end: event.end.format()
					}
				})
				.done(function(data) {
					console.log(data);
				});
		},
		//after click on the event call popup and add properties of the event
		eventClick: function(event, element) {
			console.log(event);
			$('.modal-title').text(event.title);
			if (getCookie('id_author') == event.data.id_author || getCookie('user_group') == 0) {
				$(".js__after").after("<button type='button' data-id=" + event.id + " class='btn btn-danger js__deleteEvent'>Delete Event</button>");
				$(".js__after").after("<button type='button' data-id=" + event.id + " class='btn btn-primary js__updateEvent'>Update Event</button>");
			}
			$('.modal-body>p.status').text('Status: ' + event.data.status);
			$('.modal-body>p.description').text('Description: ' + event.data.description);
			$('.modal-body>p.author').text('Author: ' + event.data.author);
			$('#myModal').modal('show');
			$('#calendar').fullCalendar('updateEvent', event);

		},
		loading: function(bool) {
			$('#loading').toggle(bool);
		}
	});
});

//removing buttons when modal hidden
$('#myModal').on('hidden.bs.modal', function(e) {
	$('.js__deleteEvent').remove();
	$('.js__updateEvent').remove();
});

//afrer click on the event get id of it, ther removing it from DB 
$(document).on('click', '.js__deleteEvent', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	$.ajax({
			url: 'calendar/delete_event.php',
			type: 'post',
			data: {
				id: id
			}
		})
		.done(function(data) {
			// console.log(data);
			$('#myModal').modal('hide');
			$('#calendar').fullCalendar('refetchEvents');
		});
});

//afrer click on the event get id of it, ther update DB 
$(document).on('click', '.js__updateEvent', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	$.ajax({
			url: 'calendar/update_event.php',
			type: 'post',
			data: {
				id: id
			}
		})
		.done(function(data) {
			$('.main').html(data);
			$('#myModal').modal('hide');
		});
});

//afrer click on the link 'js__invite' add invite form to html
$(document).on('click', '.js__invite', function(event) {
	event.preventDefault();
	$.ajax({
			url: 'mailer/index.php',
			type: 'post'
		})
		.done(function(data) {
			$('.main').html(data);
		});
});

//afrer click on the link 'js__update' add update form to html
$(document).on('click', '.js__update', function(event) {
	event.preventDefault();
	$.ajax({
			url: 'auth/update.php',
			type: 'post'
		})
		.done(function(data) {
			$('.main').html(data);
		});
});

//afrer click on the link 'js__addEvent' add 'add form' to html
$(document).on('click', '.js__addEvent', function(event) {
	event.preventDefault();
	$.ajax({
			url: 'addEvent.php',
			type: 'post'
		})
		.done(function(data) {
			$('.main').html(data);
		});
});
//afrer click on the link 'close-link' remove block frml html
$(document).on('click', 'a.close-link', function(event) {
	event.preventDefault();
	$('.invite-block, .update-block, .addEvent-block, .updateEvent-block').remove();

});
//if sign get callback 'good' add header and remove sigh form, else error alert
function processJson(data) {
	if (data[0] == 'good') {
		$.ajax({
				url: 'header.php',
				type: 'post',
				data: data
			})
			.done(function(data) {
				$('header').html(data);
			});

		$('#sign').remove();
		$('.main').removeClass('dn');
		$('#calendar').removeClass('o0');
	} else {
		alert('Wrong email/password');
	}
}
