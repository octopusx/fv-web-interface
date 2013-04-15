<?php

	class xml_iface{

		private $location;
		private $settings_1;
		private $settings_2;
		private $settings_3;
		private $settings_4;

		public function __construct($loc){
			global $location, $settings_1, $settings_2, $settings_3, $settings_4;
			$location = $loc;
			$settings_1 = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?><settings><user>";
			$settings_2 = "</user><password>";
			$settings_3 = "</password><address>";
			$settings_4 = "</address></settings>";
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
		public function loadFile($filename){
			global $location;
			return simplexml_load_file($location.$filename);
		}

		// TODO: all of the below setters need to be changed. As opposed to appending nodes, a new string has to be created and the xml file overrwriten with it
		public function getName(){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
/*			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"user")==0){
					return $child->name;
				}
			}*/
			return $xml->user;
		}

		public function setName($name){
			global $location, $settings_1, $settings_2, $settings_3, $settings_4;
			
			$xml = simplexml_load_string($settings_1.$name.$settings_2.self::getPassword().$settings_3.self::getAddress().$settings_4);
			$xml->asXML($location."settings.xml");
			return true;
		}

		public function getPassword(){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
/*			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"password")==0){
					return $child->name;
				}
			}*/
			return $xml->password;

		}

		public function setPassword($pass){
			global $location, $settings_1, $settings_2, $settings_3, $settings_4;
			
			$xml = simplexml_load_string($settings_1.self::getName().$settings_2.$pass.$settings_3.self::getAddress().$settings_4);
			$xml->asXML($location."settings.xml");
			return true;
		}

		public function getAddress(){
			global $location;
			$xml = simplexml_load_file($location."settings.xml");
/*			foreach($xml->children() as $child){
				if(strcmp($child->getName(),"address")==0){
					return $child->name;
				}
			}*/
			return $xml->address;
		}

		public function setAddress($add){
			global $location, $settings_1, $settings_2, $settings_3, $settings_4;
			
			$xml = simplexml_load_string($settings_1.self::getName().$settings_2.self::getPassword().$settings_3.$add.$settings_4);
			$xml->asXML($location."settings.xml");
			return true;			
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
