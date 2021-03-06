<?php

class FacebookProfiler{
  
  //connection data
  private $facebook;
  private $me_uid;
  private $profile_uid;
  
  //wordking data
	private $profile;
  private $statuses;
	private $groups;
	private $photos;
	private $streams;
	
	//the constructor needs the facebook connect object and the id that is to profile
	public function __construct($facebook, $profile_uid) {
	  
	  //set up the basics
		$this->facebook = $facebook;
		$this->me_uid = $facebook->getUser();
		$this->profile_uid = $profile_uid;
		
		//gather the basic data
		$this->initData();
		
	}
	
	//this loads the desired data into variables to enable to start the profiling
	private function initData(){
		
		//get the basic infos
		$this->profile = $this->facebook->api('/'.$this->profile_uid);
	  
	  //get all statuses
	  $this->statuses = $this->facebook->api(array(
      'method'  => 'fql.query',
      'query' => 'SELECT uid, time, status_id, message FROM status WHERE uid="'.$this->profile_uid.'"'
    ));

	  //get all groups
	  $this->groups = $this->facebook->api(array(
      'method'  => 'fql.query',
      'query' => 'SELECT name FROM group WHERE gid IN(SELECT gid FROM group_member WHERE uid="'.$this->profile_uid.'")'
    ));

	  //get all photos
	  $this->photos = $this->facebook->api(array(
      'method'  => 'fql.query',
      'query' => 'SELECT src_big, caption, created FROM photo WHERE pid IN(SELECT pid FROM photo_tag WHERE subject="'.$this->profile_uid.'" ORDER BY created DESC)'
    ));

	  //get all streams
	  $this->streams = $this->facebook->api(array(
      'method'  => 'fql.query',
      'query' => 'SELECT message, created_time, actor_id, comments FROM stream WHERE source_id ="'.$this->profile_uid.'" AND actor_id <>"'.$this->profile_uid.'" ORDER BY created_time DESC'
    ));

	}
	
	//this checks if any statuses, groups, photos and so on were received
	public function dataLoadingList(){
		
		//check if variables empty
		$out.="<span class='".(empty($this->profile) ? "error" : "ok")."'>Profile</span>";
		$out.=", <span class='".(empty($this->statuses) ? "error" : "ok")."'>Statuses</span>";
		$out.=", <span class='".(empty($this->groups) ? "error" : "ok")."'>Groups</span>";
		$out.=", <span class='".(empty($this->photos) ? "error" : "ok")."'>Photos</span>";
		$out.=", <span class='".(empty($this->streams) ? "error" : "ok")."'>Streams</span>";
		
		return $out;
	}
	
	//get the name of the profiled user
	public function getName(){
		return $this->profile['name'];
	}
	
	//get the name of the profiled user
	public function getStatus(){
		if(empty($this->statuses)) return '-';
		return $this->statuses[0]['message'];
	}
	
	//how many statuses has the profiled user casted
	public function getStatusCount(){
		if(empty($this->statuses)) return '-';
	  return count($this->statuses);
	}
	
	//the average status message length
	public function getAverageStatusLength(){
		
		if(empty($this->statuses)) return '-';
		
		$sumLength = 0;
		
		//sum up all status messages
		foreach ($this->statuses as $key => $status){
			$sumLength += strlen($status['message']);
		}
		
		//divide them by the amount to get the average
		return round($sumLength / $this->getStatusCount());
	}
	
	//when was the first status cast?
	public function getFirstStatusCastTime(){
		
		if(empty($this->statuses)) return '0';
		
		$firstCast = end($this->statuses);
		return $firstCastDate = $firstCast['time'];
	}
	
	//how many weeks does the user status cast?
	public function getStatusCastingWeeks(){
		
		if(empty($this->statuses)) return '-';
		
		//get the first cast timestamp and the current timestamp
		$firstCastTimestamp = $this->getFirstStatusCastTime();
		$nowTimestamp = time();
		
		//calculate the time delta and convert it to weeks
		$timeDeltaInSeconds = $nowTimestamp - $firstCastTimestamp;
		$aWeekInSeconds = 7 * 24 * 60 * 60;
		
		//divide the seconds with the week seconds to get the active weeks
		return round($timeDeltaInSeconds / $aWeekInSeconds);
	}
	
	//the activity of the user meaning, how many statuses does the user cast in a week
	public function getAverageStatusCastsPerWeek(){
		
		if(empty($this->statuses)) return '-';
		
		//divide all weeks by the status count to get the average per week
		return $this->getStatusCastingWeeks() / $this->getStatusCount();
	}
	
	//at what average time of day did the user usually cast his status?
	public function getAverageStatusCastingTime(){
		
		if(empty($this->statuses)) return '-';
		
		$sumHours = 0;
		$sumMinutes = 0;
		
		//sum up the hours and minutes of all status messages
		foreach ($this->statuses as $key => $status){
			$sumHours += intval(date('G', $status['time']));
			$sumMinutes += intval(date('i', $status['time']));
		}
		
		//divide them by the amount of statuses to get the average time
		$statusCount = $this->getStatusCount();
		return round($sumHours / $statusCount).':'.round($sumMinutes / $statusCount);
	}
	
	//filter all the status messages for an array of words. if count per status is set to 1 multiple
	//occurances of the filtered words in one status are only counted as one
	public function filterForStatusWordsCount($words = array(), $countPerStatus = 0){
		
		if(empty($this->statuses)) return '-';
		
		$sumWords = 0;
		
		//sum up the hours and minutes of all status messages
		foreach ($this->statuses as $key => $status){
			foreach ($words as $word){
				
				//search for the word
				$word = '/'.preg_quote($word).'/';
				preg_match($word, $status['message'], $matches);
				$found = count($matches);
				
				//if found is bigger than 1 add either count or 1 to the sum of the words
				if($found > 0){
					if(!$countPerStatus) $sumWords += $found;
					else $sumWords += 1;
				}
				
			}
		}
		
		//return the amount of found occurances
		return $sumWords;
	}
	
	//filter all the status messages for an array of words. if count per status is set to 1 multiple
	//occurances of the filtered words in one status are only counted as one
	public function getStatusCastingWordsCount(){
		
		if(empty($this->statuses)) return '-';
		
		$sumWords = 0;
		
		//sum up the hours and minutes of all status messages
		foreach ($this->statuses as $key => $status){
				
			//search for words
			$word = '/\w+/';
			$matches = preg_split($word, $status['message']);
			$sumWords += count($matches);		
			
		}
		
		//return the amount of found occurances
		return $sumWords;
	}
	
	//how many groups has the profiled user
	public function getGroupCount(){
		if(empty($this->groups)) return '-';
	  return count($this->groups);
	}
	
	//filter all the status messages for an array of words. if count per status is set to 1 multiple
	//occurances of the filtered words in one status are only counted as one
	public function filterForGroupWordsCount($words = array(), $countPerGroup = 0){
		
		if(empty($this->groups)) return '-';
		
		$sumWords = 0;
		
		//sum up the hours and minutes of all status messages
		foreach ($this->groups as $key => $group){
			foreach ($words as $word){
				
				//search for the word
				$word = '/'.preg_quote($word).'/';
				preg_match($word, $group['name'], $matches);
				$found = count($matches);
				
				//if found is bigger than 1 add either count or 1 to the sum of the words
				if($found > 0){
					$sumWords += 1;
				}
				
			}
		}
		
		//return the amount of found occurances
		return $sumWords;
	}
	
	//how many photos has the profiled user been tagged in
	public function getPhotoCount(){
		if(empty($this->photos)) return '-';
	  return count($this->photos);
	}
	
	//returns the javascript json array with all photo urls
	public function getPhotoListAsJSON(){
		if(empty($this->photos)) return '""';
	  return "var photos = ".json_encode($this->photos).";";
	}
	
	//how many stream items have been casted for the profiled user
	public function getStreamCount(){
		if(empty($this->streams)) return '-';
	  return count($this->streams);
	}
	
	//how many different users contributed content to the users stream
	public function getStreamActorCount(){
		
		if(empty($this->streams)) return '-';
		
		$actors = array();
		
		//add the unique actor_ids to the actors array
		foreach ($this->streams as $key => $stream){
			if(!in_array($stream['actor_id'], $actors)) array_push($actors, $stream['actor_id']);
		}
		
	  return count($actors);
	}
	
	//how many different users contributed content to the users stream
	public function getAverageStreamComments(){
		
		if(empty($this->streams)) return '-';
		
		$allComments = 0;
		
		//sum up the count of the comments
		foreach ($this->streams as $key => $stream){
			$allComments += $stream['comments']['count'];
		}
		
	  return $allComments / $this->getStreamCount();
	}
	
	//how many different users contributed content to the users stream
	public function getFirstStreamActorTime(){
		
		if(empty($this->streams)) return '0';
		
		$firstCast = end($this->streams);
		return $firstCastDate = $firstCast['created_time'];
	}
	
	//filter all the status messages for an array of words. if count per status is set to 1 multiple
	//occurances of the filtered words in one status are only counted as one
	public function filterForStreamWordsCount($words = array(), $countPerStream = 0){
		
		if(empty($this->streams)) return '-';
		
		$sumWords = 0;
		
		//sum up the hours and minutes of all status messages
		foreach ($this->streams as $key => $stream){
			foreach ($words as $word){
				
				//search for the word
				$word = '/'.preg_quote($word).'/';
				preg_match($word, $stream['message'], $matches);
				$found = count($matches);
				
				//if found is bigger than 1 add either count or 1 to the sum of the words
				if($found > 0){
					$sumWords += 1;
				}
				
			}
		}
		
		//return the amount of found occurances
		return $sumWords;
	}
	
	//how many different users contributed content to the users stream
	public function getStreamRollingStoneFactor(){
		if(empty($this->streams)) return '-';
		return ($this->getStreamActorCount() / $this->getStreamCount()) * 100;
	}
	
	//how many positive words were in all statuses and streams
	public function getTrend($filter){
		
		if(empty($this->streams)) return '-';
		
		$sumCount = 0;
		$sumTrend = 0;
		
		$sumCount += $this->getStreamCount();
		if(!empty($this->statuses)) $sumCount += $this->getStatusCount();
		if(!empty($this->groups)) $sumCount += $this->getGroupCount();
		
		$sumTrend += $this->filterForStreamWordsCount($filter);
		if(!empty($this->statuses)) $sumTrend += $this->filterForStatusWordsCount($filter);
		if(!empty($this->groups)) $sumTrend += $this->filterForGroupWordsCount($filter);
		
		return ($sumTrend / $sumCount) * 100;
	}
	
	//how many of the sources are not protected and does the user have a minimal amount of contributions
	public function getTrendQuality(){
		
		$sumSources = 5;
		$sumQuantity = 0;
		$influenceQuantity = 50;
		$quality = 100;
		
		//check what sources are protected
		if(!empty($this->statuses)) $sumSources--;
		if(!empty($this->groups)) 	$sumSources--;
		if(!empty($this->streams)) 	$sumSources--;
		if(!empty($this->photos)) 	$sumSources--;
		if(!empty($this->profile)) 	$sumSources--;
		
		//remove value if depending on the sources that are available
		$quality-= $sumSources * 20;
		
		//add up all quantities
		if(!empty($this->statuses)) $sumQuantity += $this->getStatusCount();
		if(!empty($this->groups)) 	$sumQuantity += $this->getGroupCount();
		if(!empty($this->streams)) 	$sumQuantity += $this->getStreamCount();
		if(!empty($this->photos)) 	$sumQuantity += $this->getPhotoCount();
		
		//remove value depending on the quantity of items
		$quality-= $influenceQuantity * (1/($sumQuantity+1));
		
		//fix negative quality
		if($quality < 0) $quality = 0;
		
		return $quality;
	}
	
}

?>