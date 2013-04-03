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

			if($input==null){
				include 'view/login.php';
			}else if($_GET['source']=="login"){
//				var_dump($this->model);
				self::login($input);
			}

		}

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

	}
?>
