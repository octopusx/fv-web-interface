<?php

	include("model.php");
	
	class Controller{

		private $model;

		public function __construct(){
			global $model;
			$model = new Model;
//			var_dump($this->model);
		}

		//recognises the input and calls an appropriate method
		public function action($input){
			global $model;
//			if($input==null){
			if($_GET == null){
				include 'view/login.php';
			}else if($_GET['source']=="login"){
//				var_dump($this->model);
				self::login($input);
			}else if($_GET['source']=="status"){
				self::showStatus();
			}else if($_GET['source']=="menu"){
				$user = $model->getLogin();
				$address = $model->getAddress();
				include 'view/menu.php';
			}

		}

		//processes with the login, keeps the default values if the input is empty
		public function login($input){
			global $model;
			$log = $input['uname'];
			$pw = $input['pwd'];
			$adr = $input['address'];
//			var_dump($this->$model);
			$model->login($log, $pw, $adr);

			$user = $model->getLogin();
			$address = $model->getAddress();
			include 'view/menu.php';
		}

		public function showStatus(){
			global $model;
			$status = self::resultToHTML($model->getSliceList());

			include 'view/status.php';

		}

		// takes the assoc arrays returned by the fv_iface and the model
		// and turns them in to human readable form, i.e. html tables
		// TODO: needs testing
		public function resultToHTML($array){
			$result = "<table border=1>";
			foreach($array as $x=>$x_value){
				$result .= "<tr>";
				if(is_array($x_value)){
					$result .= "<td>" . $x . "</td><td>" . self::resultToHTML($x_value) . "</td>";
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
