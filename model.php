<?php

	include_once("fv_iface.php");

	class Model{

		private $fv;// = new fv_iface();
		private $xml;

		public function __construct(){
			global $fv, $xml;
			$fv = new fv_iface();
			$xml = new xml_iface();
		}


        //---------------------------------------------------------------------------------
        //                      Monitoring API Related
        //---------------------------------------------------------------------------------


		public function login($login, $password, $address){
			global $fv;
			$fv->set_login_credentials($login, $password, $address);
		}

		public function getLogin(){
			global $fv;
			return $fv->getLogin();
		}

		public function getAddress(){
			global $fv;
			return $fv->getAddress();
		}

		public function getSliceList(){
			global $fv;
			return $fv->getSliceList();
		}

		public function getFlowSpaces($name){
			global $fv;
			return $fv->getFlowspace($name,true);

		}

		public function getVersion(){
			global $fv;
			return $fv->getVersion();
		}

		public function getConfig($name){
			global $fv;
			return $fv->getConfig($name, null);
		}



        //---------------------------------------------------------------------------------
        //                      Monitoring API Related
        //---------------------------------------------------------------------------------

		public function getSliceInfo($name){
			global $fv;
			return $fv->getSliceInfo($name);
		}

		public function getDatapaths(){
			global $fv;
			return $fv->getDatapaths();
		}

		public function getLinks(){
			global $fv;
			return $fv->getLinks();
		}

		public function getDatapathInfo($dpid){
			global $fv;
			return $fv->getDatapathInfo($dpid);
		}

		public function getSliceStats($name){
			global $fv;
			return $fv->getSliceStats($name);
		}

		public function getDatapathStats($dpid){
			global $fv;
			return $fv->getDatapathStats($dpid);
		}

		public function getFvHealth(){
			global $fv;
			return $fv->getFvHealth();
		}

		public function getSliceHealth($name){
			global $fv;
			return $fv->getSliceHealth($name);
		}

		//TODO: fill this in
		public function registerEventCallback(){

		}
		//TODO: fill this in
		public function unregisterEventCallback(){

		}


        //---------------------------------------------------------------------------------
        //                      Other Methods
        //---------------------------------------------------------------------------------

		// retrievs values from associative array $array indexed by the $attribute
		// i.e. all the slice names from getSliceList() result
		// and returns them in form of an array
		public function getAttribute($array, $attribute){
			$result=null;

			foreach($array as $x=>$x_value){
				if(strcmp($x,$attribute)==0){
					if($result == null){
						$result = array($x_value);
					}else{
						array_push($result,$x_value);
					}
				}
				if(is_array($x_value)){
					$temp = self::getAttribute($x_value,$attribute);
					if($temp!=null){
						if($result==null){
							$result = $temp;
						}else{
							array_merge((array)$result, (array)$temp);
						}
					}
				}
			}
			return $result;
		}

	}

?>
