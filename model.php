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
			$slices_resp = self::getSliceList();
			$slice_ar = self::getAttribute($slices_resp,"slice-name");
			$flowspace_list = array();
			foreach($slice_ar as $slice_name){
				if(strcmp($slice_name,"fvadmin")!=0)
var_dump($slice_name);
					$fspaces = self::getFlowSpaces($slice_name);
					array_push($flowspace_list,self::getAttribute($fspaces, "name"));
				
			}
			foreach($flowspace_list as $fs_group){
				foreach($fs_group as $fs_name){
					$fv->removeFlowspace($fs_name[0]);
				}
//print("............\n");
			}
			$result['ds']="True";
			/*
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
				$result['ds']="True";//TODO: why are both if and else making it true?
			}else{
				$result['ds']="True";			
			}
			*/
			//----------------DELETE SLICES-----------------------------------

			$slice_list = self::getAttribute(self::getSliceList(),"slice-name");

			if($slice_list!=null&&count($slice_list)>0){
				foreach($slice_list as $item){
					if(strcmp($item,"fvadmin")==0){
//						print("found fvadmin, not deleting\n");
					}else{
//						print("deleting ".$item."\n");
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
				$slice_name=null;$controller_url=null;$admin_email=null;$pwd=null;$drop_policy=null;$recv_lldp=null;$flowmod_limit=null;$rate_limit=null;$admin_status=null;			
				if(strcmp($level1->getName(),"slice")==0){
					$att = 'name';
					$slice_name = (string)$level1->attributes()->$att;
//print("Creating: ".$slice_name);
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
					}else{
						$stuff = $fv->createSlice($slice_name, $controller_url, $admin_email, 
							$pwd, $drop_policy, $recv_lldp, 
							$flowmod_limit, $rate_limit, $admin_status);
//var_dump($stuff);
					}
				}
//var_dump($fv->getSliceList());
			}

			//----------------CREATE FLOWSPACES-----------------------------------

			$result['if']="True";
			foreach($profile->children() as $slice){
				$slice_name_fs=null;$dpid=null;$priority=null;$match=null;$queues=null;$force_enqueue=null;$slice_action=null;
				if(strcmp($slice->getName(),"slice")==0){
					$att = 'name';
					$slice_name = (string)$slice->attributes()->$att;	
//var_dump($slice_name);					
					foreach($slice->children() as $flowspace){
						if(strcmp($flowspace->getName(),"flowspace")==0){

							$att2 = 'name';
							$slice_name_fs = (string)$flowspace->attributes()->$att2;
//var_dump($slice_name_fs);
							$dpid = (string)$flowspace->dpid;
//var_dump($dpid);
							$priority = (int)$flowspace->priority;//check for int
//var_dump($priority);
							$match_rules = $flowspace->match;
//var_dump($match_rules);
							$match = array();
							foreach($match_rules->children() as $rule){
//print("RULE::$rule");						
								$r_name = (string)$rule->name;
								$r_val = (string)$rule->value;
								if(is_numeric($r_val)){
									$r_val = (double)$rule->value;
								}

								$temp = array($r_name=>$r_val);
var_dump($temp);
								$match = array_merge($match, $temp);
							}
							
//							$match = (string)$flowspace->match;
//							$match = array("tp_dst"=>80,"tp_src"=>80);
//var_dump($match);
							$queues = $flowspace->queues;//array of queue ids, i presume strings, TODO: test once sorted
							$qarray = array();
							foreach($queues->children() as $item){//this needs testing
								array_push($qarray,(string)$item->id);
							}
							$queues = $qarray;
//var_dump($queues);
							$force_enqueue = (string)$flowspace->force_enqueue;//single queue id, i presume string, TODO: test once sorted
//var_dump($force_enqueue);
							$slice_action = array();
							array_push($slice_action,array("slice-name"=>$slice_name,"permission"=>(int)$flowspace->permission));
							//complicated, this needs to be an array with 1 pair of items in an array
//var_dump($slice_action);
						
							if($slice_name==null || $slice_name_fs==null || $dpid==null || $priority==null){
								$result['if']="False";
							}else{
								$stuff = $fv->addFlowspace($slice_name_fs,$dpid, $priority, 
									$match, null, null, $slice_action);
var_dump($stuff);				
							}
						}
					}
				}
			}
			//----------------APPLY SETTINGS-----------------------------------
			// Each setting must be applied separately, since each of the values can be accepted by the flowvisor multiple times, just not at once
			foreach($profile->children() as $config){
				$flood_perm=null;$flowmod_limit=null;$track_flows=null;$stats_desc=null;$enable_topo_ctrl=null;$flow_stats_cache=null;
				if(strcmp($config->getName(),"config")==0){
					$flood_perm = $config->flood_perm;//this should also be an assoc array, but till leave it as is for now
					$flowmod_limit = $config->flowmod_limit;//this will be an assoc array
					$flowmod_limit_rules = array();
					foreach($flowmod_limit->children() as $rule){
						$item = array();
						$slice = (string)$rule->slice;$dpid = (string)$rule->dpid;$limit=(int)$rule->limit;
//var_dump($slice);var_dump($dpid);var_dump($limit);
						$temp1 = array("slice-name"=>$slice);
						$temp2 = array("dpid"=>$dpid);
						$temp3 = array("limit"=>$limit);
						$item = array_merge((array)$temp1,(array)$item);
						$item = array_merge((array)$temp2,(array)$item);
						$item = array_merge((array)$temp3,(array)$item);
						array_push($flowmod_limit_rules, $item);
					}
					$track_flows = self::parseBoolean((string)$config->track_flows);
					$stats_desci = self::parseBoolean((string)$config->stats_desc);
					$enable_topo_ctrl = self::parseBoolean((string)$config->enable_topo_ctrl);
					$flow_stats_cache = (int)$config->flow_stats_cache;

					$stuff = "";
					if($flood_perm!=null){$stuff = $fv->setConfig($flood_perm,null,null,null,null,null);}
//print("\n");var_dump($stuff);
					if($flowmod_limit!=null && count($flowmod_limit_rules)>0){
						foreach($flowmod_limit_rules as $item){	
							$stuff = $fv->setConfig(null,$item,null,null,null,null);
//print("\n");var_dump($stuff);
						}
					}
					if($track_flows!=null){$stuff = $fv->setConfig(null,null,$track_flows,null,null,null);}
//print("\n");var_dump($stuff);
					if($stats_desc!=null){$stuff = $fv->setConfig(null,null,null,$stats_desc,null,null);}
//print("\n");var_dump($stuff);
					if($enable_topo_ctrl!=null){$stuff = $fv->setConfig(null,null,null,null,$enable_topo_ctrl,null);}
//print("\n");var_dump($stuff);
					if($flow_stats_cache!=null){$stuff = $fv->setConfig(null,null,null,null,null,$flow_stats_cache);}
//print("\n");var_dump($stuff);
					$result['set'] = "True";
				}
			}
			return $result;
		}

		private function parseBoolean($boolean){
			if(strcmp($boolean,"true")==0 || strcmp($boolean,"True")==0){
				return true;
			}else if(strcmp($boolean,"false")==0 || strcmp($boolean,"False")==0){
				return false;
			}else{
				return null;
			}
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
