<?php

	class xml_iface{

		private $location;

		public function __construct($loc){
			global $location;
			$location = $loc;
		}


		// displays the list of files in our working directory
		// returns an array of file names
		public function listFiles(){
			global $location;
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

		// takes path to file, returns the file contents as a string
		public function loadFile($path){
			return simplexml_load_file($path);
		}

		public function getName(){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"user")==0){
					return $child->name;
				}
			}
			return null;
		}

		public function setName($name){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"user")==0){
					$child->name = $name;
					$xml->asXML($location."settings.xml");
					return true;	
				}
			}
			return false;
		}

		public function getPassword(){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"password")==0){
					return $child->name;
				}
			}
			return null;

		}

		public function setPassword($pass){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"password")==0){
					$child->name = $pass;
					$xml->asXML($location."settings.xml");
					return true;	
				}
			}
			return false;
		}

		public function getAddress(){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"address")==0){
					return $child->name;
				}
			}
			return null;
		}

		public function setAddress($add){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"address")==0){
					$child->name = $add;
					$xml->asXML($location."settings.xml");
					return true;	
				}
			}
			return false;
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
