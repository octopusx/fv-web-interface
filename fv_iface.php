<?php 

class fv_iface{
  //The names of the methods that can be invoked on the flowvisor using the json api
	public $GET_SLICE_LIST = "list-slices";//"getSliceList";
	public $CREATE_SLICE = "createSlice";
	public $UPDATE_SLICE = "updateSlice";
	public $REMOVE_SLICE = "removeSlice";
	public $GET_SLICE_INFO = "getSliceInfo";
	public $GET_SLICE_STATS = "getSliceStats";
	public $UPDATE_PASSWORD = "updatePasswd";
	public $UPDATE_ADMIN_PASSWORD = "updateAdminPasswd";
	public $GET_DATAPATH_STATS = "getDatapathStats";
	public $GET_DATAPATH_FLOW_DB = "getDatapathFlowDB";
	public $GET_FLOW_SPACE = "getFlowSpace";
	public $REMOVE_FLOW_SPACE = "removeFlowSpace";
	public $ADD_FLOW_SPACE = "removeFlowSpace";
	public $UPDATE_FLOW_SPACE = "updateFlowSpace";
	public $GET_DATAPATHS = "getDatapaths";
	public $GET_DATAPATH_INFO = "getDatapathInfo";
	public $GET_LINKS = "getLinks";
	public $PING = "ping";
	public $REGISTER_CALLBACK = "registerCallback";
	public $UNREGISTER_CALLBACK = "unregisterCallback";
	public $SET_FLOOD_PERMISSION = "setFloodPerm";
	public $GET_FLOOD_PERMISSION = "getFloodPerm";
	public $SET_LOGGING_FACILITY = "setLoggingFacility";
	public $GET_LOGGING_FACILITY = "getLoggingFacility";
	public $SET_LOGGING_IDENTIFIER = "setLoggingIdent";
	public $GET_LOGGING_IDENTIFIER = "getLoggingIdent";
	public $SET_FLOW_TRACKING = "setFlowTracking";
	public $GET_FLOW_TRACKING = "getFlowTracking";
	public $SET_STATS_DESCRIPTION = "setStatsDescription";
	public $GET_STATS_DESCRIPTOPN = "getStatsDescription";
	public $SET_DROP_POLICY = "setDropPolicy";
	public $GET_DROP_POLICY = "getDropPolicy";
	public $SET_RECEIVE_LLDP = "setRecvLLDP";
	public $GET_RECEIVE_LLDP = "getRecvLLDP";

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
		$request = array("jsonrpc"=>"2.0","method"=>$this->GET_SLICE_LIST,"id"=>$this->request_count);
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

		$ch = curl_init('https://localhost:8080');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
		curl_setopt($ch, CURLOPT_USERPWD,$this->user .":" .$this->pwd );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($json))

		);
		
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
