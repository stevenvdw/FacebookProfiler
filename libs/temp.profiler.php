<?php 
/*
This is the view for the profiler that outputs the calculated variables in a certain form

Possible values are:
$me_uid => UID of the logged in user
$profile_uid => UID of the user to profile

*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>Profiler</title>
		<script type="text/javascript" src="libs/jquery.js"></script>
		<link href="libs/profiler.css" media="screen" rel="stylesheet" type="text/css" />
	<body class="frame">
		<?php print_r($statuses); ?>
	</body>
</html>