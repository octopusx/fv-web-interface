<?php

	class profile{


		private $slices;
		private $config;

		public __construct(){
		}

		//-------------------------------------------
		//		setters and getters
		//-------------------------------------------

		// slices setter and getter
		public function getSlices(){
			global $slices;
			return $slices;
		}

		public function getSlice($n){
			global $slices;
			if($n<self::getSliceCount()-1){
				return $slices[$n];
			}else{
				return null;
			}
		}

		public function setSlices($s){
			global $slices;
			$slices = $s;
		}

		public function addSlice($s){
			global $slices;
			if($slices!=null&&is_array($slices)){
				array_push($slices, $s);
			}
		}

		public function getSliceCount(){
			global $slices;
			if($slices!=null&&is_array($slices)){
				return count($slices);
			}
		}

		// config setter and getter
		public function getConfig(){
			global $config;
			return $config;
		}

		public function setConfig($c){
			global $config;
			$config = $c;

		}

	}

?>
