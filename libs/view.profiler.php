<?php 
/*
This is the view for the profiler the displays the desired variables of the facebook profiler 
object. 

$facebookProfiler is the basic object here, see the class to know the available functions

*/

//how to format the dates
$date_format = 'l, d.m.Y - H:i';

//positive words list
$positive_words = array('easy', 'amazing', 'wonderful', 'great', 'cool', 'fantastic', 'marvellous', 'happy',
'fun', 'sun', 'party', 'legendary', 'funny');

//positive words list
$negative_words = array('bad', 'sad', 'unhappy', 'horrible', 'embarrasing', 'ridiculous', 'synical', 'unsafe',
'punished', 'lonely', 'misunderstood', 'rejected', 'unimportant', 'insane');

//party words list
$party_words = array('party', 'drunk', 'wasted', 'hang', 'over', 'last night', 'puke', 'throw up',
'drink', 'beer', 'cocktail', 'alcohol', 'drugs');

//vulgarity words list
$vulgarity_words = array('sex', 'fuck', 'bitch', 'idiot', 'ass hole', 'retarded', 'dumb ass', 'fool',
'cunt', 'clit', 'dork', 'whore', 'nude');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>Profiler</title>
		<script type="text/javascript" src="libs/jquery.js"></script>
		<script type="text/javascript" src="libs/photos.js"></script>
		<link href="libs/profiler.css" media="screen" rel="stylesheet" type="text/css" />
	<body class="frame">
	  
	  <table>
			<tr>
			    <th>Variable</th>
			    <th>Value</th>
					<th>Explanation</th>
			</tr>
			
			<tr>
				<td>Name</td>
				<td><?php echo $facebookProfiler->getName(); ?></td>
				<td><small>The name of the user</small></td>
			</tr>
			
			<tr>
				<td>Loading Status</td>
				<td><?php echo $facebookProfiler->dataLoadingList(); ?></td>
				<td><small>What data streams are not privacy proteced and accessible?</small></td>
			</tr>
			
			<tr>
				<td colspan='3'><h3>Statuses</h3></td>
			</tr>
			
			<tr>
				<td>Status Count</td>
				<td><?php echo $facebookProfiler->getStatusCount(); ?></td>
				<td><small>The amount of statuses that have been casted</small></td>
			</tr>
			
			<tr>
				<td>Status Casting Weeks</td>
				<td><?php echo $facebookProfiler->getStatusCastingWeeks(); ?> Weeks</td>
				<td><small>How many weeks is the user already status casting?</small></td>
			</tr>
			
			<tr>
				<td>First Status Cast Date</td>
				<td><?php echo date($date_format, $facebookProfiler->getFirstStatusCastTime()); ?></td>
				<td><small>When did the user cast his first status?</small></td>
			</tr>
			
			<tr>
				<td>Average Status Cast Activity per Week</td>
				<td><?php echo $facebookProfiler->getAverageStatusCastsPerWeek(); ?></td>
				<td><small>How active is the user with his status casting in a week?</small></td>
			</tr>
			
			<tr>
				<td>Average Status Length</td>
				<td><?php echo $facebookProfiler->getAverageStatusLength(); ?> Characters</td>
				<td><small>How long was the average status message?</small></td>
			</tr>
			
			<tr>
				<td>Average Status Casting Time</td>
				<td><?php echo $facebookProfiler->getAverageStatusCastingTime(); ?></td>
				<td><small>When did the user cast the statuses in the average?</small></td>
			</tr>
			
			<tr>
				<td>Positive Words Filter in Status Casts</td>
				<td><?php echo $facebookProfiler->filterForStatusWordsCount($positive_words); ?></td>
				<td>
					<small>How often did the user mention one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $positive_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Negative Words Filter in Status Casts</td>
				<td><?php echo $facebookProfiler->filterForStatusWordsCount($negative_words); ?></td>
				<td>
					<small>How often did the user mention one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $negative_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Party Words Filter in Status Casts</td>
				<td><?php echo $facebookProfiler->filterForStatusWordsCount($party_words); ?></td>
				<td>
					<small>How often did the user mention one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $party_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Vulgarity Words Filter in Status Casts</td>
				<td><?php echo $facebookProfiler->filterForStatusWordsCount($vulgarity_words); ?></td>
				<td>
					<small>How often did the user mention one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $vulgarity_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td colspan='3'><h3>Groups</h3></td>
			</tr>
			
			<tr>
				<td>Group Count</td>
				<td><?php echo $facebookProfiler->getGroupCount(); ?></td>
				<td><small>The amount of groups the user is in</small></td>
			</tr>
			
			<tr>
				<td>Positive Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($positive_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $positive_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Negative Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($negative_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $negative_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Party Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($party_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $party_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Vulgarity Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($vulgarity_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $vulgarity_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td colspan='3'><h3>Stream</h3></td>
			</tr>
			
			<tr>
				<td>Stream Count</td>
				<td><?php echo $facebookProfiler->getStreamCount(); ?></td>
				<td><small>The amount of stream items that have been added by other users </small></td>
			</tr>
			
			<tr>
				<td>Distinct Stream Actors Count</td>
				<td><?php echo $facebookProfiler->getStreamActorCount(); ?></td>
				<td><small>How many different users contributed content to the users stream?</small></td>
			</tr>
			
			<tr>
				<td>Rolling Stone Actor Factor</td>
				<td><?php echo $facebookProfiler->getStreamRollingStoneFactor(); ?>%</td>
				<td><small>How many different users contributed content to the users stream in therelation to all contributions?</small></td>
			</tr>
			
			<tr>
				<td>Average Stream Comments</td>
				<td><?php echo $facebookProfiler->getAverageStreamComments(); ?></td>
				<td><small>How many comments have averagely been made to every stream entry?</small></td>
			</tr>
			
			<tr>
				<td>First Stream Contribution Date</td>
				<td><?php echo date($date_format, $facebookProfiler->getFirstStreamActorTime()); ?></td>
				<td><small>When did someone contribute content to the stream for the first time?</small></td>
			</tr>
			
			<tr>
				<td>Positive Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($positive_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $positive_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Negative Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($negative_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $negative_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Party Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($party_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $party_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Vulgarity Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($vulgarity_words); ?></td>
				<td>
					<small>How often contains the group name one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $vulgarity_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td colspan='3'><h3>Photos</h3></td>
			</tr>
			
			<tr>
				<td>Photo Tags</td>
				<td><?php echo $facebookProfiler->getPhotoCount(); ?></td>
				<td><small>How many photos of the user have been tagged</small></td>
			</tr>
			
			<tr>
				<td colspan='3'>
					<script><?php echo $facebookProfiler->getPhotoListAsJSON(); ?></script>
					<div id="photo"></div>
				</td>
			</tr>
		
			
	  </table>
		
	</body>
</html>