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
			$slice_name		=null;
			$controller_url		=null;
			$admin_email		=null;
			$pwd			=null;
			$drop_policy		=null;
			$recv_lldp		=null;
			$flowmod_limit		=null;
			$rate_limit		=null;
			$admin_status		=null;
			//flowspace args
			$slice_name_fs		=null;
			$dpid			=null; 
			$priority		=null;
			$match			=null;
			$queues			=null;
			$force_enqueue		=null;
			$slice_action		=null;
			//config args
			$flood_perm		=null;
			$flowmod_limit		=null; //assoc array-> slice_name, dpid, limit
			$track_flows		=null;
			$stats_desc		=null;
			$enable_topo_ctrl	=null;
			$flow_stats_cache	=null;
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
			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());			
			// loading the profile xml file
			$profile = $xml->loadFile($filename);
			if($profile==null){return $result;}
			//----------------DELETE FLOWSPACES-----------------------------------
			$flowspace_list = self::getFlowSpaces(null);
			// here need to use the getAttribute and get the result.
			// if the result is empty, then set 
			$flowspace_result_set = self::getAttribute($flowspace_list, "result");
			// TODO: needs testing once have some flowspaces down
			if(is_array($flowspace_result_set) && count($flowspace_result_set[0])>0){
				$flowspace_name = "";
				foreach($flowspace_result_set[0] as $item){
					$flowspace_name = self::getAttribute($item, "name");
					$fv->removeFlowspace($flowspace_name);
				}
				$result['ds']="True";
			}else{
				$result['ds']="True";			
			}
			//----------------DELETE SLICES-----------------------------------

			$slice_list = self::getAttribute(self::getSliceList(),"slice-name");

			if($slice_list!=null&&count($slice_list)>0){
				foreach($slice_list as $item){
					if(strcmp($item,"fvadmin")==0){
						print("found fvadmin, not deleting\n");
					}else{
						print("deleting ".$item."\n");
						$fv->deleteSlice($item);
					}
				}
				$result['df']="True";
			}else{
				$result['df']="False";
			}

			//----------------CREATE SLICES-----------------------------------
			$result['is']="True";
			foreach($profile->children() as $level1){
				$slice_name=null;$controller_url=null$admin_email=null;$pwd=null;$drop_policy=null;$recv_lldp=null;$flowmod_limit=null;$rate_limit=null;$admin_status=null;			
				if(strcmp($level1->getName(),"slice")==0){
					$att = 'name';
					$slice_name = (string)$level1->attributes()->$att;
print("Creating: ".$slice_name);
					$controller_url = (string)$level1->controller_url;
					$admin_email = (string)$level1->admin_email;
					$pwd = (string)$level1->password;
					$drop_policy = (string)$level1->drop_policy;
					$recv_lldp = (string)$level1->receive_lldp;
					if(strcmp($recv_lldp,"true")==0){
						$recv_lldp = true;
					}else if(strcmp($recv_lldp,"false")==0){
						$recv_lldp = false;
					}else{
						$recv_lldp = null;
					}
					$flowmod_limit = (string)$level1->flowmod_limit;
					if(is_int($flowmod_limit)){
						$flowmod_limit = (int)$flowmod_limit;
					}else{
						$flowmod_limit = null;
					}
					$rate_limit = (string)$level1->rate_limit;
					if(is_int($rate_limit)){
						$rate_limit = (int)$rate_limit;
					}else{
						$rate_limit = null;
					}
					$admin_status = (string)$level1->admin_status;
					if(strcmp($admin_status,"true")==0){
						$admin_status = true;
					}else if(strcmp($admin_status,"false")==0){
						$admin_status = false;
					}else{
						$admin_status = null;
					}


					if($slice_name==null || $controller_url==null || $admin_email==null || $pwd==null){
						$result['is']="False";
						return $result;
					}

					$stuff = $fv->createSlice($slice_name, $controller_url, $admin_email, 
							$pwd, $drop_policy, $recv_lldp, 
							$flowmod_limit, $rate_limit, $admin_status);
//var_dump($stuff);							
				}
//var_dump($fv->getSliceList());
			}

			//----------------CREATE FLOWSPACES-----------------------------------

			foreach($profile->children() as $level1){
			$slice_name_fs=null;$dpid=null;$priority=null;$match=null;$queues=null;$force_enqueue=null;$slice_action=null;
				if(strcmp($level1->getName(),"slice")==0){
					$att = 'name';
					$slice_name = (string)$level1->attributes()->$att;
				
					
					$slice_name_fs;
					$dpid;
					$priority;
					$match;
					$queues;
					$force_enqueue;
					$slice_action;
					
				}
			}
			//----------------APPLY SETTINGS-----------------------------------

			foreach($profile->children() as $level1){
				if(strcmp($level1->getName(),"config")==0){
					
				}
			}
			
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
/*
		public function getStoredCredentials(){
			global $xml;
			return $result = array("uname"=>$xml->getName(),
						"password"=>$xml->getPassword(),
						"address"=>$xml->getAddtess());
		}
*/
		public function getLogin(){
			global $fv;
			return $fv->getLogin();
		}

		public function getAddress(){
			global $fv;
			return $fv->getAddress();
		}

		public function getSliceList(){
			global $fv, $xml;
//			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());
//var_dump($fv->getSliceList());
			return $fv->getSliceList();
		}

		public function createSlice($name, $ctrl_url, $admin_email, 
			$pwd, $drop_policy, $recv_lldp, 
			$flowmod_limit, $rate_limit, $admin_status){

			global $fv, $xml;
//			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());	
			$fv->createSlice($name, $ctrl_url, $admin_email, 
				$pwd, $drop_policy, $recv_lldp, 
				$flowmod_limit, $rate_limit, $admin_status);
		}

		public function deleteSlice($name){
			global $fv, $xml;
//			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());			
			$fv->deleteSlices($name);
		}

		public function getFlowSpaces($name){
			global $fv, $xml;
			return $fv->getFlowspace($name,true);

		}

		public function createFlowSpace($name, $dpid, $priority, 
			$match, $queues, $force_enqueue, $slice_action){
			global $fv, $xml;
//			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());			
			$fv->addFlowspace($name, $dpid, $priority, 
				$match, $queues, $force_enqueue, $slice_action);
		}

		public function getVersion(){
			global $fv, $xml;
//			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());			
			return $fv->getVersion();
		}

		public function getConfig($name){
			global $fv, $xml;
//			$fv->set_login_credentials($xml->getName(), $xml->getPassword(), $xml->getAddress());			
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
			$result=array();

			foreach($array as $x=>$x_value){
				if(strcmp($x,$attribute)==0){
					array_push($result,$x_value);
				}
				if(is_array($x_value)){
					$temp = self::getAttribute($x_value,$attribute);
					if(count($temp)>0){
						foreach($temp as $y){
							array_push($result, $y);
						}
					}
				}
			}
			return $result;
		}

	}

?>
