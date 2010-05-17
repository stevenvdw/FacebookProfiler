<?php

require 'libs/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '111354375573799',
  'secret' => '516da1d61e6b6c36327ba14db92155ad',
  'cookie' => true, // enable optional cookie support
));

$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>Facebook Profiler</title>
		<link href="libs/profiler.css" media="screen" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
				
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>


		<table id="header">
			<tr>
				<td width="90%"><h1>Facebook Profiler</h1></td>
				<td>
					
					<!-- login and logout button -->
					<div class="box">
					<table>

						<tr>
							<td>
								<?php if ($me): ?>
									<img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
								<?php endif ?>
							</td>
							<td>
								<?php if ($me): ?>
									<a href="<?php echo $logoutUrl; ?>"><img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif"></a><br />
									<a href="<?php echo $me['link']; ?>"><?php echo $me['name']; ?></a>
								<?php else: ?>
						    	<div><fb:login-button></fb:login-button></div>
						    <?php endif ?>
							</td>
						</tr>

					</table>
					</div>
					
				</td>
			</tr>
			
		</table>

		 <fb:activity>


    <h3>Session</h3>
    <?php if ($me): ?>
    <pre><?php print_r($session); ?></pre>
    

    <h3>Your User Object</h3>
    <pre><?php print_r($me); ?></pre>
    <?php endif ?>

  </body>
</html>