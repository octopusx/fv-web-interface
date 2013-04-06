<?php

	class slice{

		private $controler_url;
		private $admin_email;
		private $password;
		private $drop_policy;
		private $receive_lldp;
		private $flowmod_limit;
		private $rate_limit;
		private $admin_status;
		private $flowspaces; //array

		public __construct(){

		}

		public function setSlice($cu, $ae, $pw, $dp, $rlldp, $fl, $rl, $as, $fs){
			global $controler_url, $admin_email, $password, $drop_policy, $receive_lldp, $flowmod_limit, $rate_limit, $admin_status, $flowspaces;
			if($cu!=null){$controler_url = $cu;}
			if($ae!=null){$admin_email = $ae;}
			if($pw!=null){$password = $pw;}
			if($dp!=null){$drop_policy = $dp;}
			if($rlldp!=null){$receive_lldp = $rlldp;}
			if($fl!=null){$flowmod_limit = $fl;}
			if($rl!=null){$rate_limit = $rl;}
			if($as!=null){$admin_status = $as;}
			if($fs!=null){$flowspaces = $fs;}
		}

		//-------------------------------------------
		//		setters and getters
		//-------------------------------------------

		// controler url setter and getter
		public function getControlerUrl(){
			global $controler_url;
			return $controler_url;
		}

		public function setControlerUrl($cont){
			global $controler_url;
			$controler_url = $cont;
		}

		// admin email setter and getter
		public function getAdminEmail(){
			global $admin_email;
			return $admin_email;
		}

		public function setAdminEmail($mail){
			global $admin_email;
			$admin_email = $mail;
		}

		// password setter and getter
		public function getPassword(){
			global $password;
			return $password;
		}

		public function setPassword($pass){
			global $password;
			$password = $pass;
		}

		// drop policy setter and getter
		public function getDropPolicy(){
			global $drop_policy;
			return $drop_policy;
		}

		public function setDropPolicy($drop){
			global $drop_policy;
			$drop_policy = $drop;
		}

		// receive lldp setter and getter
		public function getReceiveLLDP(){
			global $receive_lldp;
			return $receive_lldp;		
		}

		public function setReceiveLLDP($rec){
			global $receive_lldp;
			$receive_lldp = $rec;
		}

		// flowmod limit setter and getter
		public function getFlowmodLimit(){
			global $flowmod_limit;
			return $flowmod_limit;
		}

		public function setFlowmodLimit($fl){
			global $flowmod_limit;
			$flowmod_limit = $fl;
		}

		// rate limit setter and getter
		public function getRateLimit(){
			global $rate_limit;
			return $rate_limit;
		}

		public function setRateLimit($rl){
			global $rate_limit;
			$rate_limit = $rl;
		}

		// admin status setter and getter
		public function getAdminStatus(){
			global $admin_status;
			return $admin_status;
		}

		public function setAdminStatus($as){
			global $admin_status;
			$admin_status = $as;
		}

		// flowspaces array
		public function getFlowspaces(){
			global $flowspaces;
			return $flowspaces;
		}

		public function setFlowspaces($fs){
			global $flowspaces;
			$flowspaces = $fs;
		}

		public function getFlowspaceCount(){
			global $flowspaces;
			return count($flowspaces);
		}

	}
?>
