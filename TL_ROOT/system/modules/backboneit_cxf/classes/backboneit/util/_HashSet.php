<?php

class HashSet {
	
	protected $arrSet;
	
	public function contains(Identifiable $obj) {
		$varHash = $obj->hash();
		
		if(!isset($this->arrSet[$varHash]))
			return false;
			
		return $this->bucketPosition($this->arrSet[$varHash], $obj) !== false;
	}
	
	public function add(Identifiable $obj) {
		$varHash = $obj->hash();
		
		if(!isset($this->arrSet[$varHash])
		|| $this->bucketPosition($this->arrSet[$varHash], $obj) === false) {
			$this->arrSet[$varHash][] = $obj;
			return true;
			
		} else {
			return false;
		}
	}
	
	public function remove(Identifiable $obj) {
		$varHash = $obj->hash();
		
		if(!isset($this->arrSet[$varHash]))
			return;
			
		$intPosition = $this->bucketPosition($this->arrSet[$varHash], $obj);
		
		if($intPosition === false)
			return;
			
		array_splice($this->arrSet[$varHash], $intPosition, 1);
	}
	
	protected function bucketPosition(array $arrBucket, Identifiable $obj) {
		foreach($arrBucket as $intIndex => $obj2)
			if($obj->equals($obj2))
				return $intIndex;
				
		return false;
	}
	
}
