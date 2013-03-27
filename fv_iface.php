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


	function fv_iface(){
		
	}	

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
	// $name - slice name
	// $crtl_url - url of the controler to be pointed at
	// $admin_email - the contact email address of the admin responsible for the slice
	// $pwd - slice password
	// $drop_policy - policy for droping packets: "exact" (default) or "rule"
	// $recv_lldp - boolean, default = false
	// $flowmod_limit - a number, defaults to -1
	// $rate_limit - number, defaults to -1
	// $admin_status - boolean, defaults to true
	function createSlice($name, $crtl_url, $admin_email, $pwd, $drop_policy, $recv_lldp, $flowmod_limit, $rate_limit, $admin_status){
		//create the parameter array
		$params = array("slice-name"=>$name,
			"controller-url"=>$crtl_url,
			"admin-contact"=>$admin_email,
			"password"=>$pwd,
			"drop-policy"=>$drop_policy,
			"recv-lldp"=>$recv_lldp,
			"flowmod-limit"=>$flowmod_limit,
			"rate-limit"=>$rate_limit,
			"admin-status"=>$admin_status);
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
		//create the parameter array
		$params = array("slice-name"=>$name,
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


	//this function will be used to post the json messages to the api
	function send($json){
		//initialise the curl connection on the flowvisor api address
		$ch = curl_init('https://localhost:8080');
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
		print "result: $result <br>";
		return $result;
	}


}

?>
