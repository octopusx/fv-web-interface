<?php

	class flowspace(){

		private $name;
		private $slice;
		private $dpid;
		private $priority;
		private $match;
		private $queues;
		private $force_enqueue;
		private $permissions;

		public __construct(){
		}


		public function setFlowspace($nm, $sl, $dp, $pr, $ma, $qu, $fe, $pe){
			global $name, $slices, $dpid, $priority, $match, $queues, $force_enqueue, $permissions;

			if($nm!=null){$name = $ne;}
			if($sl!=null){$slices = $sl;}
			if($dp!=null){$dpid = $dp;}
			if($pr!=null){$priority = $pr;}
			if($ma!=null){$match = $ma;}
			if($qu!=null){$queues = $qu;}
			if($fe!=null){$force_enqueue = $fe;}
			if($pe!=null){$permissions = $pe;}
		}

		//-------------------------------------------
		//		setters and getters
		//-------------------------------------------

		public function getName(){
			global $name;
			return $name;
		}

		public function setName($n){
			global $name;
			$name = $n;
		}

		public function getSlice(){
			global $slice;
			return $slice;
		}

		public function setSlice($s){
			global $slice;
			$slice = $s;
		}
		public function getDpid(){
			global $dpid;
			return $dpid;
		}

		public function setDpid($d){
			global $dpid;
			$dpid = $d;
		}
		public function getPriority(){
			global $priority;
			return $priority;
		}

		public function setPriority($p){
			global $priority;
			$priority = $p;
		}
		public function getMatch(){
			global $match;
			return $match;
		}

		public function setMatch($m){
			global $match;
			$match = $m;
		}
		public function getQueues(){
			global $queues;
			return $queues;
		}

		public function setQueues($q){
			global $queues;
			$queues = $q;
		}
		public function getForceEnqueue(){
			global $force_enqueue;
			return $force_enqueue;
		}

		public function setForceEnqueue($f){
			global $force_enqueue;
			$force_enqueue = $f;
		}
		public function getPermissions(){
			global $permissions;
			return $permisions;
		}

		public function setPermissions($p){
			global $permissions;
			$permissions = $p;
		}


	{

?>
