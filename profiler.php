<?php

//init the profiler
require 'libs/init.profiler.php';


$statuses = $facebook->api(array(
  'method'  => 'fql.query',
  'query' => 'SELECT uid,status_id,message FROM status WHERE uid="'.$profile_uid.'"'
));

//render the template
require 'libs/temp.profiler.php';

?>