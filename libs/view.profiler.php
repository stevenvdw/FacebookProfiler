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
'fun', 'sun', 'legendary', 'funny');

//german additions
array_push($positive_words, 'einfach', 'super', 'toll', 'klasse', 'prima', 'gut', 'wunderbar', 'stark', 
'fantastisch', 'glücklich', 'spass', 'sonne', 'legendär', 'witzig');

//positive words list
$negative_words = array('bad', 'sad', 'unhappy', 'horrible', 'embarrasing', 'ridiculous', 'synical', 'unsafe',
'punished', 'lonely', 'misunderstood', 'rejected', 'unimportant', 'insane');

//german additions
array_push($negative_words, 'schlecht', 'traurig', 'unglücklich', 'schrecklich', 'peinlich', 'lächerlich',
'zynisch', 'unsicher', 'bestraft', 'einsam', 'unwichtig', 'verrückt', 'blöd', 'uncool');

//party words list
$party_words = array('party', 'drunk', 'wasted', 'hang', 'over', 'last night', 'puke', 'throw up',
'drink', 'beer', 'cocktail', 'alcohol', 'drugs');

//german additions
array_push($party_words, 'partey', 'betrunken', 'besoffen', 'kater', 'letzte nacht', 'spucken',
'kotzen', 'trinken', 'bier', 'alkohol', 'drogen', 'kondom', 'übel', 'blau', 'flitzen');

//vulgarity words list
$vulgarity_words = array('sex', 'fuck', 'bitch', 'idiot', 'ass hole', 'retarded', 'dumb ass',
'cunt', 'clit', 'dork', 'whore', 'nude');

//german additions
array_push($vulgarity_words, 'ficken', 'schlampe', 'arschloch', 'fick dich', 'dummkopf', 'pussy',
'vollidiot', 'hure', 'nackt');

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
				<td><small>What data sources are not privacy proteced and accessible?</small></td>
			</tr>
			
			<tr>
				<td colspan='3'><h3>Profile Trend</h3></td>
			</tr>
			
			<tr>
				<td>Positive</td>
				<td style="color: green;"><?php echo $facebookProfiler->getTrend($positive_words); ?>%</td>
				<td><small>Based on the positive words in relation to all casted streams</small></td>
			</tr>
			
			<tr>
				<td>Negative</td>
				<td style="color: blue;"><?php echo $facebookProfiler->getTrend($negative_words); ?>%</td>
				<td><small>Based on the negative words in relation to all casted streams</small></td>
			</tr>
			
			<tr>
				<td>Party</td>
				<td style="color: orange;"><?php echo $facebookProfiler->getTrend($party_words); ?>%</td>
				<td><small>Based on the party words in relation to all casted streams</small></td>
			</tr>
			
			<tr>
				<td>Vulgarity</td>
				<td style="color: red;"><?php echo $facebookProfiler->getTrend($vulgarity_words); ?>%</td>
				<td><small>Based on the vulgarity words in relation to all casted streams</small></td>
			</tr>
			
			<tr>
				<td>Trend Quality</td>
				<td><?php echo $facebookProfiler->getTrendQuality(); ?>%</td>
				<td><small>Based on the accessible sources and quantity of contributions</small></td>
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
				<td>Status Words Count</td>
				<td><?php echo $facebookProfiler->getStatusCastingWordsCount(); ?></td>
				<td><small>How many words did the user cast ever?</small></td>
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
				<td><small>How many groups did the user join?</small></td>
			</tr>
			
			<tr>
				<td>Positive Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($positive_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $positive_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Negative Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($negative_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $negative_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Party Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($party_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $party_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Vulgarity Words Filter in Group Names</td>
				<td><?php echo $facebookProfiler->filterForGroupWordsCount($vulgarity_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $vulgarity_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td colspan='3'><h3>Stream</h3></td>
			</tr>
			
			<tr>
				<td>Stream Count</td>
				<td><?php echo $facebookProfiler->getStreamCount(); ?></td>
				<td><small>The amount of stream items that have been added by OTHER users</small></td>
			</tr>
			
			<tr>
				<td>Distinct Stream Actors Count</td>
				<td><?php echo $facebookProfiler->getStreamActorCount(); ?></td>
				<td><small>How many different users contributed content to the users stream?</small></td>
			</tr>
			
			<tr>
				<td>Rolling Stone Actors Factor</td>
				<td><?php echo $facebookProfiler->getStreamRollingStoneFactor(); ?>%</td>
				<td><small>How many different users contributed content to the users stream in relation to all contributions?</small></td>
			</tr>
			
			<tr>
				<td>Average Stream Comments</td>
				<td><?php echo $facebookProfiler->getAverageStreamComments(); ?></td>
				<td><small>How many comments has every stream entry in the average?</small></td>
			</tr>
			
			<tr>
				<td>First Stream Contribution Date</td>
				<td><?php echo date($date_format, $facebookProfiler->getFirstStreamActorTime()); ?></td>
				<td><small>The first time someone contributed content to the stream?</small></td>
			</tr>
			
			<tr>
				<td>Positive Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($positive_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $positive_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Negative Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($negative_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $negative_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Party Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($party_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $party_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td>Vulgarity Words Filter in Stream Messages</td>
				<td><?php echo $facebookProfiler->filterForStreamWordsCount($vulgarity_words); ?></td>
				<td>
					<small>How often does the group name contain one of the specified words:</small><br />
					<div class='words'><small><i><?php echo implode(', ', $vulgarity_words); ?></i></small></div>
				</td>
			</tr>
			
			<tr>
				<td colspan='3'><h3>Photos</h3></td>
			</tr>
			
			<tr>
				<td>Photo Tags</td>
				<td><?php echo $facebookProfiler->getPhotoCount(); ?></td>
				<td><small>How many photos of the user have been tagged?</small></td>
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