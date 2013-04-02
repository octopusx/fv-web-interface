<?php

	include_once("model.php");
	
	class Controller{

		public $model;

		public function __construct(){
			$this->model = new Model();
//			var_dump($this->model);
		}

		//recognises the input and calls an appropriate method
		public function action($input){
//			var_dump($input);
			if($input==null){
				include 'view/login.php';
			}else if($_GET['source']=="login"){
				self::login($input);
			}

		}

		public function login($input){
			$log = $input['uname'];
			$pw = $input['pwd'];
			$adr = $input['address'];
			var_dump($model);
			$this->model->login($log, $pw, $adr);

			$user = $this->model->getLogin();
			$address = $this->model->getAddress();
			include 'view/menu.php';
		}

	}
?>
