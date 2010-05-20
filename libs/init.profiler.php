<?php

//load the pre-build facebook classes
require 'facebook.php';

//instantiate a new facebook object
$facebook = new Facebook(array(
  'appId'  => '111354375573799',
  'secret' => '516da1d61e6b6c36327ba14db92155ad',
  'cookie' => true
));

//get the session
$session = $facebook->getSession();
$profile_uid = null;

//check login session
if ($session) {
  try {
    $me_uid = $facebook->getUser();
		$profile_uid = $_REQUEST['profile'];
    //$me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
		header('Location: '.$facebook->getLoginUrl(array('req_perms' => 'read_stream,user_status,friends_status,read_friendlists')));
    error_log($e);
  }
}

?>