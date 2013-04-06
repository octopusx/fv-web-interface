<?php

	class config{

		private $flood_perm;
		private $flowmod_limit; //array
		private $track_flows;
		private $stats_desc;
		private $enable_topo_ctrl;
		private $flow_stats_cache;

		public __construct(){

		}

		//-------------------------------------------
		//		setters and getters
		//-------------------------------------------


		// flooding permission setter and getter
		public function getFloodPerm(){
			global $flood_perm;
			return $flood_perm;
		}

		public function setFloodPerm($f){
			global $flood_perm;
			$flood_perm = $f;
		}

		// flowmod limit attay setter and getter + counter
		public function getFlowmodLimit(){
			global $flowmod_limit;
			return $flowmod_limit;
		}

		public function getFlowmodLimit($n){
			global $flowmod_limit;
			return $flowmod_limit[$n];
		}

		public function setFlowmodLimit($f){
			global $flowmod_limit;
			$flowmod_limit = $f;
		}

		public function getFlowmodLimitCount(){
			global $flowmod_limit;
			return count($flowmod_limit);
		}

		// track flows setter and getter
		public function getTrackFlows(){
			global $track_flows;
			return $track_flows;
		}

		public function setTrackFlows($tf){
			global $track_flows;
			$track_flows = $tf;
		}

		// stats desctiption setter and getter
		public function getStatsDesc(){
			global $stats_desc;
			return $stats_desc;
		}

		public function setStatsDesc($sd){
			global $stats_desc;
			$stats_desc = $sd;
		}

		// enable topokigy control setter and getter
		public function getEnableTopoCtrl(){
			global $enable_dopo_ctrl;
			return $enable_topo_ctrl;
		}

		public function setEnableTopoCtrl($etc){
			global $enable_topo_ctrl;
			$enable_topo_ctrl = $etc;
		}

		//flow stats cache setter and gtter
		public function getFlowStatsCache(){
			global $flow_stats_cache;
			return $flow_stats_cache;
		}

		public function setFlowStatsCache($fsc){
			global $flow_stats_cache;
			$flow_stats_cache = $fsc;
		}

	}

	class flowmod_limit_rule{


		private $slice;
		private $dpid;
		private $limit;

		public __construct($s, $d, $l){
			global $slice, $dpid, $limit;
			$slice = $s;
			$dpid = $d;
			$limit = $l;
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

		public function setdpid($d){
			global $dpid;
			$dpid = $d;
		}

		public function getLimit(){
			global $limit;
			return $limit;
		}

		public function setLimit($l){
			global $limit;
			$limit = $l;
		}



	}

?>
