<?php

	include_once("fv_iface.php");

	class Model{

		private $fv;// = new fv_iface();

		public function __construct(){
			global $fv;
			$fv = new fv_iface();
		}


		public function login($login, $password, $address){
			global $fv;
			$fv->set_login_credentials($login, $password, $address);
		}

		public function getLogin(){
			global $fv;
			return $fv->getLogin();
		}

		public function getAddress(){
			global $fv;
			return $fv->getAddress();
		}

		public function getSliceList(){
			global $fv;
			return $fv->getSliceList();
		}

	}

?>
