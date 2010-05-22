<?php

class FacebookProfiler{
  
  //connection data
  private $facebook;
  private $me_uid;
  private $profile_uid;
  
  //wordking data
	private $profile;
  private $statuses;
	
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
    
	}
	
	//get the name of the profiled user
	public function getName(){
		return $this->profile['name'];
	}
	
	//how many statuses has the profiled user casted
	public function getStatusCount(){
	  return count($this->statuses);
	}
	
	//the average status message length
	public function getAverageStatusLength(){
		
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
		$firstCast = end($this->statuses);
		return $firstCastDate = $firstCast['time'];
	}
	
	//how many weeks does the user status cast?
	public function getStatusCastingWeeks(){
		
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
		
		//divide all weeks by the status count to get the average per week
		return $this->getStatusCastingWeeks() / $this->getStatusCount();
	}
	
	//at what average time of day did the user usually cast his status?
	public function getAverageStatusCastingTime(){
		
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
	public function filterForWordsCount($words = array(), $countPerStatus = 0){
		
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
	
}

?>