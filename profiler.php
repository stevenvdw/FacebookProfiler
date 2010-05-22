<?php

//init the profiler & load the profiler
require 'libs/init.profiler.php';
require 'libs/class.profiler.php';

//create the profiler and pass it over to the view
$facebookProfiler = new FacebookProfiler($facebook, $profile_uid);

//render the template
require 'libs/view.profiler.php';

?>