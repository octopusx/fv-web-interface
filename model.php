<?php

	include_once("fv_iface.php");
	include_once("xml_iface.php");

	class Model{

		private $fv;// = new fv_iface();
		private $xml;

		public function __construct(){
			global $fv, $xml, $xmlPath;
			$fv = new fv_iface();
			$xml = new xml_iface("./xml/");

			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());
		}

		// takes 
		public function loadConfig($filename){
			global $fv, $xml;
			//slice args
			$slice_name;
			$controller_url;
			$admin_email;
			$pwd;
			$drop_policy;
			$recv_lldp;
			$flowmod_limit;
			$rate_limit;
			$admin_status;
			//flowspace args
			$slice_name_fs;
			$dpid; 
			$priority;
			$match;
			$queues;
			$force_enqueue;
			$slice_action;
			//config args
			$flood_perm;
			$flowmod_limit; //assoc array-> slice_name, dpid, limit
			$track_flows;
			$stats_desc;
			$enable_topo_ctrl;
			$flow_stats_cache;
			// reslult associative array
			$result = array("df"=>"False",
				"ds"=>"False",
				"rs"=>"False",
				"is"=>"False",
				"if"=>"False",
				"set"=>"False");
			// first delete all the flowspaces
			// then delete all the current slices
			// then create new slices
			// create new flowspaces
			// change the config settings

			$slice_list = self::getAttribute(self::getSliceList(),"slice-name");
var_dump($slice_list);
//			$flowspace_list = 

			$profile = $xml->loadFile($filename);

			
			return $result;
		}

        //---------------------------------------------------------------------------------
        //                      Config API Related
        //---------------------------------------------------------------------------------


		public function login($login, $password, $address){
			global $fv, $xml;
			$xml->setName($login);
			$xml->setPassword($password);
			$xml->setAddress($address);
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

		public function createSlice($name, $ctrl_url, $admin_email, 
			$pwd, $drop_policy, $recv_lldp, 
			$flowmod_limit, $rate_limit, $admin_status){

			global $fv;
			$fv->createSlice($name, $ctrl_url, $admin_email, 
				$pwd, $drop_policy, $recv_lldp, 
				$flowmod_limit, $rate_limit, $admin_status);
		}

		public function deleteSlice($name){
			global $fv;
			$fv->deleteSlices($name);
		}

		public function getFlowSpaces($name){
			global $fv;
			return $fv->getFlowspace($name,true);

		}

		public function createFlowSpace($name, $dpid, $priority, 
			$match, $queues, $force_enqueue, $slice_action){
			global $fv;
			$fv->addFlowspace($name, $dpid, $priority, 
				$match, $queues, $force_enqueue, $slice_action);
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
        //                      XML related
        //---------------------------------------------------------------------------------

		public function getProfileList(){
			global $xml;
			$list = $xml->listFiles();
			$final = null;

			foreach($list as $item){
				if(strstr($item,"settings",false)==false&&strcmp($item,".")!=0&&strcmp($item,"..")!=0){
					if($final==null){
						$final = array($item);
					}else{
						array_push($final, $item);
					}
				}
			}
			$final2 = array();
			$j = count($final)-1;
			for($i = 0; $i<count($final); $i++){
				array_push($final2, $final[$j]);
				$j--;
			}

			return $final2;
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
