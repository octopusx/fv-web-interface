<?php

	include_once("model.php");
	
	class Controller{

		private $model;

		public function __construct(){
			global $model;
			$model = new Model();
		}

		//recognises the input and calls an appropriate method
		public function action($input){
			global $model;
			if($_GET == null){
				include 'view/login.php';
			}else if($_GET['source']=="login"){
				self::login($input);
			}else if($_GET['source']=="status"){
				self::showStatus();
			}else if($_GET['source']=="menu"){
				$user = $model->getLogin();
				$address = $model->getAddress();
				include 'view/menu.php';
			}else if($_GET['source']=="xml"){
				self::configurationList();
			}else if($_GET['source']=="load"){
				self::loadConfig();
			}

		}

		//processes with the login, keeps the default values if the input is empty
		public function login($input){
			global $model;
			$log = $input['uname'];
			$pw = $input['pwd'];
			$adr = $input['address'];
			$model->login($log, $pw, $adr);

			$user = $model->getLogin();
			$address = $model->getAddress();
			include 'view/menu.php';
		}

		// pulls the information out of the model, formats it in form of html table and passes as variables to the status view
		public function showStatus(){
			global $model;

			$slices_resp = $model->getSliceList();
			$slices = self::resultToHTML($slices_resp,1);

			//--------------------------------------------

			$slice_ar = $model->getAttribute($slices_resp,"slice-name");
			$flowspaces_resp = array();
			$flowspaces = array();

			if($slice_ar==null || count($slice_ar)<=0){
				$flowspaces = "<table border=1><tr><td>No Slices, Hende No Flowspaces Defined</td></tr></table>";
print("WTF!");
			}else{
				foreach($slice_ar as $x){
					array_push($flowspaces_resp, $model->getFlowSpaces($x));
				}
				if($flowspaces_resp==null || !is_array($flowspaces_resp) || count($flowspaces_resp)<1 || $flowspaces_resp[0] == null){
					$flowspaces = "<table border=1><tr><td>No Flowspaces Defined</td></tr></table>";
				}else{
					foreach($flowspaces_resp as $x){
						array_push($flowspaces, self::resultToHTML($x,1));
					}
				}
			}

			//--------------------------------------------

			$version = self::resultToHTML($model->getVersion(),1);

			//--------------------------------------------

			$config_resp = array();
			$config = array();

			if($slice_ar==null || count($slice_ar)<=0){
				$config = "<table border=1><tr><td>No Slices With Settings</td><tr></table>";
			}else{
				foreach($slice_ar as $x){
					array_push($config_resp, $model->getConfig($x));
				}

				foreach($config_resp as $x){
					array_push($config, self::resultToHTML($x,1));
				}
			}

			//--------------------------------------------

			$sinfo_resp = array();
			$sinfo = array();

			if($slice_ar==null || count($slice_ar)<=0){
				$sinfo = "<table border=1><tr><td>No Slices</td></tr></table>";
			}else{
				foreach($slice_ar as $x){
					array_push($sinfo_resp, $model->getSliceInfo($x));
				}

				foreach($sinfo_resp as $x){
					array_push($sinfo, self::resultToHTML($x,1));
				}
			}

			//--------------------------------------------

			$datapath_resp = $model->getDatapaths();
			$datapaths = self::resultToHTML($datapath_resp,1);
			if($datapaths == null){$datapaths = "<table border=1><tr><td>No Datapaths</td></tr></table>";}

			//--------------------------------------------

			$links = self::resultToHTML($model->getLinks(),1);
			if($links == null){$links = "<table border=1><tr><td>No Links</td></tr></table>";}

			//--------------------------------------------

			$datapath_ar = $model->getAttribute($datapath_resp,"dpid");
			$dinfo_resp = array();
			$dinfo = array();

			if($datapath_ar!=null && count($datapath)>0){
				foreach($datapath_ar as $x){
					array_push($dinfo_resp, $model->getDatapathInfo($x));
				}

				foreach($dinfo_resp as $x){
					array_push($dinfo, self::resultToHTML($x,1));
				}
			}else{
				$dinfo = "<table border=1><tr><td>No Devices Connected</td></tr></table>";
			}

			//--------------------------------------------

			$sstats_resp = array();
			$sstats = array();

			if($slice_ar!=null && count($slice_ar)>0){
				foreach($slice_ar as $x){
					array_push($sstats_resp, $model->getSliceStats($x));
				}

				foreach($sstats_resp as $x){
					array_push($sstats, self::resultToHTML($x,1));
				}
			}else{
				$sstats = "<table border=1><tr><td>No Slices Set Up</td></tr></table>";
			}

			//--------------------------------------------

			$dstats_resp = array();
			$dstats = array();

			if($datapath_ar!=null && count($datapath_ar)>0){
				foreach($datapath_ar as $x){
					array_push($dstats_resp, $model->getDatapathStats($x));
			}

				foreach($dstats_resp as $x){
					array_push($dstats, self::resultToHTML($x,1));
				}
			}else{
				$dstats = "<table border=1><tr><td>No Devices Connected</td></tr></table>";
			}

			//--------------------------------------------

			$fvhealth = self::resultToHTML($model->getFvHealth(),1);

			//--------------------------------------------

			$shealth_resp = array();
			$shealth = array();

			if($slice_ar!=null && count($slice_ar)>0){
				foreach($slice_ar as $x){
					array_push($shealth_resp, $model->getSliceHealth($x));
				}
				if($shealth_resp==null || !is_array($shealth_resp) || count($shealth_resp)<1 || $shealth_resp[0] == null || strlen($shealth_resp[0])<1){
					$shealth = "<table border=1><tr><td>No Slices Set Up</td></tr></table>";

				}else{
					foreach($shealth_resp as $x){
						array_push($shealth, self::resultToHTML($x,1));
					}
				}
			}else{
				$shealth = "<table border=1><tr><td>No Slices Set Up</td></tr></table>";
			}
			//--------------------------------------------

			include 'view/status.php';

		}

		public function configurationList(){
			global $model;
			$file_list = $model->getProfileList();
			include 'view/config_management.php';
		}

		public function loadConfig(){
			global $model;
			
			$filename = $model->getProfileList();
			$filename = $filename[$_GET['xml']];
			$result = $model->loadConfig($filename);
			$delete_flowspaces = "Flowspaces Deleted: ".$result['df'];
			$delete_slices = "Slices Deleted: ".$result['ds'];
			$reset_settings = "Settings Reset: ".$result['rs'];
			$install_slices = "Slices Installed: ".$result['is'];
			$install_flowspaces = "Flowspaces Installed: ".$result['if'];
			$install_settings = "Settings Installed: ".$result['set'];

			include 'view/load_profile.php';
		}

		// takes the assoc arrays returned by the fv_iface and the model
		// and turns them in to human readable form, i.e. html tables
		public function resultToHTML($array, $ignore){
			// this is a misterious null pointer check
			// at the beginning it was not neccessary, but adding it stops the program from crashing on the 
			// slice health information tertieval
			if($array==null){
				return "";
			}
			$result = "<table border=r>";
			foreach($array as $x=>$x_value){
				$result .= "<tr>";
				if(is_array($x_value)){
					//this if is used to ignore unneccesary outer tables
					if($ignore>0){
						$result = self::resultToHTML($x_value, $ignore-1);
						return $result;
					}
					$result .= "<td>" . $x . "</td><td>" . self::resultToHTML($x_value, $ignore-1) . "</td>";
				}else{
					$result .= "<td>" . $x . "</td><td>" . $x_value . "</td>";
				}
				$result .= "</tr>";
			}
			$result .= "</table>";
			return $result;
		}
	}
?>
