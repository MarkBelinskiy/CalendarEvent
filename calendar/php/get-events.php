<?php

//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';
require_once '../../db/db_connect.php';

function filter(&$value) {
  $value = htmlspecialchars_decode($value);
}
function check_in_range($start_date, $end_date)
{
  // Convert to timestamp
	$start_ts = strtotime($start_date);
	$end_ts = strtotime($end_date);
	$date = new DateTime();
	$user_ts = $date->getTimestamp();
	if (($user_ts >= $start_ts) && ($user_ts <= $end_ts)) {
		return 0;
	} elseif ($user_ts >= $start_ts) {
		return 1;
	}  elseif ($user_ts <= $end_ts) {
		return 2;
	}
}

$get_events = "SELECT id_event as 'id', Events.id_author, Authors.name as 'author', Events.name as 'title', description, date_start as 'start', date_end as 'end', color as 'backgroundColor' from Events
JOIN Authors ON Events.id_author = Authors.id_author;
";
$get_events = $db->prepare($get_events);
$get_events->execute();
$input_arrays = $get_events->fetchAll(PDO::FETCH_ASSOC);
// print_r($get_events->errorInfo());

array_walk_recursive($input_arrays, "filter");

foreach ($input_arrays as $key => $value) {
	if (check_in_range($input_arrays[$key]['start'], $input_arrays[$key]['end']) == 0) {
		$input_arrays[$key]['data'] = array('status' => 'in-progress');
	} elseif (check_in_range($input_arrays[$key]['start'], $input_arrays[$key]['end']) == 1) {
		$input_arrays[$key]['data'] = array('status' => 'Done');
	} elseif (check_in_range($input_arrays[$key]['start'], $input_arrays[$key]['end']) == 2) {
		$input_arrays[$key]['data'] = array('status' => 'New');
	}
	
	$input_arrays[$key]['title'] .= ': '.$input_arrays[$key]['data']['status'];

	$input_arrays[$key]['data'] += array('id_author' => $value['id_author']);
	$input_arrays[$key]['data'] += array('description' => $value['description']);
	$input_arrays[$key]['data'] += array('author' => $value['author']);
	unset($input_arrays[$key]['id_author'], $input_arrays[$key]['description']);
}

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
	die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($_GET['timezone'])) {
	$timezone = new DateTimeZone($_GET['timezone']);
}

// Accumulate an output array of event data arrays.
$output_arrays = array();
foreach ($input_arrays as $array) {

	// Convert the input array into a useful Event object
	$event = new Event($array, $timezone);

	// If the event is in-bounds, add it to the output
	if ($event->isWithinDayRange($range_start, $range_end)) {
		$output_arrays[] = $event->toArray();
	}
}

// Send JSON to the client.
echo json_encode($output_arrays);