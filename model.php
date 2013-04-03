<?php

	include_once("fv_iface.php");

	class Model{

		private $fv;// = new fv_iface();

		public function __construct(){
			$this->fv = new fv_iface();
		}


		public function login($login, $password, $address){
			$this->fv->set_login_credentials($login, $password, $address);
		}




	}

?>
