<?php 

class fv_iface{
	//The names of the methods that can be invoked on the flowvisor using the json api
	//Configuration API
	public $GET_SLICE_LIST = "list-slices";
	public $CREATE_SLICE = "add-slice";
	public $UPDATE_SLICE = "update-slice";
	public $REMOVE_SLICE = "remove-slice";
	public $UPDATE_SLICE_PWD = "update-slice-password";
	public $GET_FLOWSPACE_LIST = "list-flowspace";
	public $CREATE_FLOWSPACE = "add-flowspace";
	public $REMOVE_FLOWSPACE = "remove-flowspace";
	public $UPDATE_FLOWSPACE = "update-flowspace";
	public $GET_VERSION = "list-version";
	public $SET_CONFIG = "set-config";
	public $GET_CONFIG = "get-config";
	public $SAVE_CONFIG = "save-config";

	//Monitoring API
	public $GET_SLICE_INFO = "list-slice-info";
	public $GET_DATAPATHS = "list-datapaths";
	public $GET_LINKS = "list-links";
	public $GET_DATAPATH_INFO = "list-datapath-info";
	public $GET_SLICE_STATS = "list-slice-stats";
	public $GET_DATAPATH_STATS = "list-datapath-stats";
	public $GET_FV_HEALTH = "list-fv-health";
	public $GET_SLICE_HEALTH = "list-slice-health";
	public $REGISTER_EVENT_CALLBACK = "register-event-callback";
	public $UNREGISTER_EVENT_CALLBACK = "unregister-event-callback";

	private $request_count = 0;
	private $user = "fvadmin";
	private $pwd = "flowvisor";
	private $serv = "https://192.168.0.9:8080";

	function fv_iface(){
		
	}	

	//---------------------------------------------------------------------------------
	//			Configuration API
	//---------------------------------------------------------------------------------


	//this function will create an associative array which will then be turned in to a json object.
	//that object will then be passed to the "send" function, which will call pass it to our fv.
	//example request:
	//{"jsonrpc" : "2.0",  "method" : "<method>",  "params" :  <args> ,  "id" : <id>}
	function getSliceList(){
		//compile the request in form of an array
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->GET_SLICE_LIST,
			"id"=>$this->request_count);
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// creates a slice with all the appropriate parameters
	// return null if anything goes wrong
	// $name - slice name
	// $ctrl_url - url of the controler to be pointed at
	// $admin_email - the contact email address of the admin responsible for the slice
	// $pwd - slice password
	// $drop_policy - policy for droping packets: "exact" (default) or "rule"
	// $recv_lldp - boolean, default = false
	// $flowmod_limit - a number, defaults to -1
	// $rate_limit - number, defaults to -1
	// $admin_status - boolean, defaults to true
	function createSlice($name, $ctrl_url, $admin_email, $pwd, $drop_policy, $recv_lldp, $flowmod_limit, $rate_limit, $admin_status){
		//test if any of the non-optional variables are null	
		if($name==null || $ctrl_url==null || $admin_email==null || $pwd==null){
			return null;
		}

		//create the parameter array
		$params = array("slice-name"=>$name,
			"controller-url"=>$ctrl_url,
			"admin-contact"=>$admin_email,
			"password"=>$pwd);

		//add any optional variables if they are null
		if($drop_policy!=null){
			$temp = array("drop-policy"=>$drop_policy);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($recv_lldp!=null){
			$temp = array("recv-lldp"=>$recv_lldp);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($rate_limit!=null){
			$temp = array("rate-limit"=>$rate_limit);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($admin_status!=null){
			$temp = array("admin-status"=>$admin_status);
			$params = array_merge((array)$params, (array)$temp);
		}

		//compile the request
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->CREATE_SLICE,
			"id"=>$this->request_count,
			"params"=>$params);
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// removes named slice
	// $name - slice name
	function deleteSlice($name){
		//check for null pointers
		if($name==null){
			return null;
		}
		//create the parameter array
		$params = array("slice-name"=>$name);
		//compile the request
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->REMOVE_SLICE,
			"id"=>$this->request_count,
			"params"=>$params);
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// updates a chosen slice
	// all variables except name and email address are optiona
	// no password field taken
	// returns null if anything goes wrong
	// name		- string
	// ctrl_url	- hostname
	// ctrl_port	- port number
	// admin_email	- emaik
	// drop_policy	- exact|rule
	// recv_lldp	- boolean
	// flowmod_limit- number
	// rate_limit	- number
	// admin_status	- boolean
	function updateSlice($name, $ctrl_url, $ctrl_port, $admin_email, $drop_policy, $recv_lldp, $flowmod_limit, $rate_limit, $admin_status){
	
		if($name == null || $admin_email == null){
			return null;
		}	

		$params = array("slice-name"=>$name, "admin-contact"=>$admin_email);
		if($ctrl_url!=null){
			$temp = array("controller-host"=>$ctrl_url);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($ctrl_port!=null){
			$temp = array("controller-port"=>$ctrl_port);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($drop_policy!=null){
			$temp = array("drop-policy"=>$drop_policy);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($recv_lldp!=null){
			$temp = array("recv-lldp"=>$recv_lldp);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($flowmod_limit!=null){
			$temp = array("flowmod-limit"=>$flowmod_limit);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($rate_limit!=null){
			$temp = array("rate-limit"=>$rate_limit);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($admin_status!=null){
			$temp = array("admin-status"=>$admin_status);
			$params = array_merge((array)$params, (array)$temp);
		}

		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->UPDATE_SLICE,
			"id"=>$this->request_count,
			"params"=>$params);

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true); 
	}

	// updates the password of a given slice
	function updateSlicePassword($name, $pwd){

		//check for any null pointers
		if($name==null || $pwd==null){
			return null;
		}

		//create the parameter array
		$params = array("slice-name"=>$name,
			"password"=>$pwd);
		//creating the request 
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->UPDATE_SLICE_PWD,
			"id"=>$this->request_count,
			"params"=>$params);

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// retrievs the flowspace information
	// all parameters are optional
	// name 	- string
	// show_disabled- boolean
	// TODO: this should be tested further when we actually add some flowspaces
	function getFlowspace($name, $show_disabled){
		
		$params = null;

		if($name!=null){
			$params = array("name"=>$name);
		}
		if($show_disabled!=null){
			if($params == null){
				$params = array("show-disabled"=>$show_disabled);
			}else{
				$temp = array("show-disabled"=>$show_disabled);
				$params = array_merge((array)$params, (array)$temp);
			}
		}

		//creating the request 
		if($params==null){
			$params = (object)'';
			$request = array("jsonrpc"=>"2.0",
				"method"=>$this->GET_FLOWSPACE_LIST,
				"id"=>$this->request_count,
				"params"=>$params);
			
		}else{
			$request = array("jsonrpc"=>"2.0",
				"method"=>$this->GET_FLOWSPACE_LIST,
				"id"=>$this->request_count,
				"params"=>$params);
		}

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// creates a new flowspace rule
	// name			- string
	// dpid			- the id of the openflow deivces connected to this fv
	//			+ it is 8 bytes long, a wildcard can be used: ff:ff:ff:ff:ff:ff:ff
	// priority		- the priority number which helps to disambiguate which action should be performed 
	//			+ if many flowspace rules overlap
	// match		- the match rule, probably string with coma-separated var defs 
	//			+ TODO: need to check this, compare to fvctl man page and test it
	// queues		- optionam array of queue ids, TODO: check where this comes from
	// force_enqueue	- optional, single queue id
	// slice_action 	- array of tuples - slice name and permission value 
	//			+ (delegate = 1, read = 2, write = 4, they add up like a bit mask).
	// TODO: needs to be tested!!
	function addFlowspace($name, $dpid, $priority, $match, $queues, $force_enqueue, $slice_action){

		//check for null pointers on required fields
		if($name==null || $dpid==null || $priority==null || $match==null  || $slice_action==null){
			return null;
		}
		
		//saving the non-optional parameters
		$params = array("name"=>$name,
			"dpid"=>$dpid,
			"priority"=>$priority,
			"match"=>$match,
			"slice-action"=>$slice_action);
			
		//checking for optional parameters
		if($queues!=null){
			$temp = array("queues"=>$queues);
			$params = array_merge((array)$params, (array)$temp);
		}

		if($force_enqueue!=null){
			$temp = array("force_enqueue"=>$force_enqueue);
			$params = array_merge((array)$params, (array)$temp);
		}

		//creating the request
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->CREATE_FLOWSPACE,
			"id"=>$this->request_count,
			"params"=>$params);

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// removes a flowspace, named as the given parameter
	// name 		- flowspace name, string, obligatory
	//TODO: needs to be tested!!
	function removeFlowspace($name){

		//null pointer check
		if($name==null){
			return null;
		}

		//create the parameter array
		$params = array("flowspace-name"=>$name);
		//creating the request 
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->REMOVE_FLOWSPACE,
			"id"=>$this->request_count,
			"params"=>$params);

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}


	// everything like in the createFlowspace, except that only the name is a non-optional parameter
	// need to check if there is a minimum of one optional parameter required...
	// TODO: needs to be tested!!
	function updateFlowspace($name, $dpid, $priority, $match, $queues, $force_enqueue, $slice_action){

		//check for null pointers on required fields
		if($name==null){
			return null;
		}
		
		//saving the non-optional parameters
		$params = array("name"=>$name);
			
		//checking for optional parameters
		if($dpid!=null){
			$temp = array("dpid"=>$dpid);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($priority!=null){
			$temp = array("priority"=>$priority);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($match!=null){
			$temp = array("match"=>$match);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($queues!=null){
			$temp = array("queues"=>$queues);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($force_enqueue!=null){
			$temp = array("force_enqueue"=>$force_enqueue);
			$params = array_merge((array)$params, (array)$temp);
		}
		if($slice_action!=null){
			$temp = array("slice-action"=>$slice_action);
			$params = array_merge((array)$params, (array)$temp);
		}
		//creating the request
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->UPDATE_FLOWSPACE,
			"id"=>$this->request_count,
			"params"=>$params);

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);

	}
	// returns the flowvisor and db version information
	function getVersion(){
		//creating the request
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->GET_VERSION,
			"id"=>$this->request_count);

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);	
	}

	/* used to configure the flowvisor, change any settings
	*  $flood_perm			- assoc array, includes "slice-name" and "dpid", optional
	*  $flowmod_limit		- assoc array, includes "slice-name", "dpid" and "limit" number, optional
	*  $track_flows			- boolean, optional
	*  $stats_desc			- boolean, optional
	*  $enable_topo_ctrl		- boolean, optional 
	*  flow_stats_cache		- number of seconds, optional
	*  as  all the paramteters are optional, at least one must be not null
	*  TODO: needs testing!!
	*/ 
	function setConfig($flood_perm, $flowmod_limit, $track_flows, $stats_desc, $enable_topo_ctrl, $flow_stats_cache){

		if($flood_perm == null && $flowmod_limit == null && $track_flows == null && $stats_desc == null && $enable_topo_ctrl == null && $flow_stats_cache == null){
			return null;
		}

		$params = null;
			
		if($flood_perm!=null){
			$params = array("dpid"=>$dpid);
		}
		
		if($flowmod_limit!=null){
			if($params!=null){
				$temp = array("flowmod-limit"=>$flowmod_limit);
				$params = array_merge((array)$params, (array)$temp);
			}else{
				$params = array("flowmod-limit"=>$flowmod_limit);
			}
		}
		if($track_flows!=null){
			if($params!=null){
				$temp = array("track-flows"=>$track_flows);
				$params = array_merge((array)$params, (array)$temp);
			}else{
				$params = array("track-flows"=>$track_flows);
			}
		}
		if($stats_desc!=null){
			if($params!=null){
				$temp = array("stats-desc"=>$stats_desc);
				$params = array_merge((array)$params, (array)$temp);
			}else{
				$params = array("state-desc"=>$stats_desc);
			}
		}
		if($enable_topo_ctrl!=null){
			if($params!=null){
				$temp = array("enable-topo-ctrl"=>$emable_topo_ctrl);
				$params = array_merge((array)$params, (array)$temp);
			}else{
				$params = array("enable-topo-ctrl"=>$enable_topo_ctrl);
			}
		}
		if($flow_stats_cache!=null){
			if($params!=null){
				$temp = array("flow-stats-cache"=>$flow_stats_cache);
				$params = array_merge((array)$params, (array)$temp);
			}else{
				$params = array("flow-state-cache"=>$flow_state_cache);
			}
		}
		//creating the request
		$request = array("jsonrpc"=>"2.0",
			"method"=>$this->SET_CONFIG,
			"id"=>$this->request_count,
			"params"=>$params);

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);

	
	}

	// retrievs the config information, all parameters optional
	// $slice_name 			- string, optional
	// $dpid			= dpid value, optional
	// TODO: needs tesing!!
	function getConfig($slice_name, $dpid)

		
		$params = null;

		if($slice_name!=null){
			$params = array("slice-name"=>$slice_name);
		}
		if($dpid!=null){
			if($params == null){
				$params = array("dpid"=>$dpid);
			}else{
				$temp = array("dpid"=>$dpid);
				$params = array_merge((array)$params, (array)$temp);
			}
		}

		//creating the request 
		if($params==null){
			$params = (object)'';
			$request = array("jsonrpc"=>"2.0",
				"method"=>$this->GET_CONFIG,
				"id"=>$this->request_count,
				"params"=>$params);
			
		}else{
			$request = array("jsonrpc"=>"2.0",
				"method"=>$this->GET_CONFIG,
				"id"=>$this->request_count,
				"params"=>$params);
		}

		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// returns the config as a text blob
	// TODO: needs teesting!!
	function saveConfig(){
	
		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->SAVE_CONFIG,
		"id"=>$this->request_count);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	//---------------------------------------------------------------------------------
	//			Monitoring API
	//---------------------------------------------------------------------------------

	// $slice_name 				- name of the slice in question, compulsory
	// TODO: not yet tested
	function getSliceInfo($name){

		$params = array("slice-name"=>$name);

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_SLICE_INFO,
		"id"=>$this->request_count,
		"params"=>$params);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// lists the dpids, so lets us discover devices connected to the fv
	// no parameters required
	// TODO: not yet tested
	function getDatapaths(){

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_DATAPATHS,
		"id"=>$this->request_count);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// maps the links between the devices (dpids)
	// no params
	// TODO: not tested yet
	function getLinks(){

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_LINKS,
		"id"=>$this->request_count);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// $pdid 			-compulsory field, id of a device
	// TODO: not tested yet
	function getDatapathInfo(){

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_DATAPATH_INFO,
		"id"=>$this->request_count);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// gets the list of messages from all senders on the slice, sorted by tx, rx and droped.
	// $name			- name of thes lice, compulsiory
	// TODO: needs testing
	function getSliceStats($name){

		if($name==null){
			return null;
		}

		$params = array("slice-name"=>$name);

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_SLICE_STATS,
		"id"=>$this->request_count,
		"params"=>$params);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}
	// same as the slice stats, but for datapaths
	// $dpid 			- device id, compulsory
	// TODO: needs testing
	function getDatapathStats($dpid){

		if($dpid==null){
			return null;
		}

		$params = array("dpid"=>$dpid);

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_DATAPATH_STATS,
		"id"=>$this->request_count,
		"params"=>$params);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// returns average delay, instnt delay, active db sessions and idle db sessions
	// TODO: needs testing
	function getFvHealth(){

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_FV_HEALTH,
		"id"=>$this->request_count);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// returns connection status, connection drop count, fs entries (?) and connected dpids
	// $name 			- name of the slice, compulsory
	// TODO: needs testing
	function getSliceHealth($name){

		if($name==null){
			return null;
		}

		$params = array("slice-name"=>$name);

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->GET_SLICE_HEALTH,
		"id"=>$this->request_count,
		"params"=>$params);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);

	}

	// $url 			- not sure, maybe the url to which the callback is done
	// $method			- the method name called by the callback
	// $event_type			- "DEVICE_CONECTED" | "SLICE_CONNECTED" | "SLICE_DISCONNECTED"
	// $name			- the name for the callback
	// all fields compulsory
	// returns a boolean
	// TODO: needs testing
	function registerCallbackEvent($url, $method, $event_type, $name){

		if($url==null||$method==null||$event_type==null||$name==null){
			return null;
		}

		$params = array("url"=>$url,
			"method"=>$method,
			"event-type"=>$event_type,
			"name"=>$name);

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->REGISTER_CALLBACK_EVENT,
		"id"=>$this->request_count,
		"params"=>$params);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	// $method			- the method name called by the callback
	// $event_type			- "DEVICE_CONECTED" | "SLICE_CONNECTED" | "SLICE_DISCONNECTED"
	// $name			- the name for the callback
	// all fields compulsory
	// returns a boolean
	// TODO: needs testing

	function unregisterEventCallback($method, $event_type, $name){

		if($method==null||$event_type==null||$name==null){
			return null;
		}

		$params = array("method"=>$method,
			"event-type"=>$event_type,
			"name"=>$name);

		$request = array("jsonrpc"=>"2.0",
		"method"=>$this->UNREGISTER_CALLBACK_EVENT,
		"id"=>$this->request_count,
		"params"=>$params);
	
		//increase the request id count
		$this->request_count++;
		//encode the array in to a json string
		$this->requestJson = json_encode($request);
		//send the json request
		$result = $this->send($this->requestJson);
		//decode the result and return it
		return json_decode($result,true);
	}

	//---------------------------------------------------------------------------------
	//			Other Functions
	//---------------------------------------------------------------------------------


	//this function will be used to post the json messages to the api
	function send($json){
		//initialise the curl connection on the flowvisor api address
		$ch = curl_init($this->serv);
		//set the connection in "POST" mode
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		//set the json string as a post field
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		//set the ssl verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
		//set the user and password to access the fv
		curl_setopt($ch, CURLOPT_USERPWD,$this->user .":" .$this->pwd );
		//set the curl to return the server output
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//initialise the header
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($json))

		);
		//execute the connection and receive the response	
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			print curl_error($ch);
		} else {
			//echo "curl closing";
			curl_close($ch);
		}
//		print "result: $result <br>";
		return $result;
	}


}

?>
