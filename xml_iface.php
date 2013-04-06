<?php

	class xml_iface{

		private $location;

		public __construct($loc){
			global $location;
			$location = $loc;
		}


		// displays the list of files in our working directory
		// returns an array of file names
		public function listFiles(){
			$result = null;
			if($handle = opendir($location)){
				while(false !== ($entry = readdir($handle))){
					if($result == null){
						$result = array($entry);
					}else{
						array_push($result, $entry);
					}	
				}
			}

			return $result;
		}



		public function getLocation(){
			global $location;
			return $location;
		}

		public function setLocation($loc){
			global $location;
			$location = $loc;
		}

	}

?>
