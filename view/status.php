<html>
	<head></head>
	<body>
<?php
//	include("fv_iface.php");
//	$fv_test = new fv_iface;
//	var_dump($fv_test->getSliceHealth("fvadmin"));
?>
		<h3>Flowvisor Configuration Tool</h3>
		<h4>FlowVisor Status</h4>
		<h5>Config Info</h5>

		<p>Slices</br>
		<?php echo $slices; ?>
		</p>

		<p>FlowSpaces</br>
		<?php
			if(is_array($flowspaces)){
				for($i = 0; $i<count($slice_ar);$i++){
					echo $slice_ar[$i]."</br>";
					echo $flowspaces[$i]."</br>";
				}
			}else{
				echo $flowspaces;
			}
		 ?>
		</p>

		<p>Configuration Info Per Slice</br>
		<?php
			if(is_array($config)){
				for($i = 0; $i<count($slice_ar);$i++){
					echo $slice_ar[$i]."</br>";
					echo $config[$i]."</br>";
				}
			}else{
				echo $config;
			}
		?>
		</p>

		<p>Version Info</br>
		<?php echo $version;?>
		</p>

		<h5>Monitoring Info</h5>

		<p>Slice Details</br>
		<?php
			if(is_array($sinfo)){
				for($i = 0; $i<count($slice_ar);$i++){
					echo $slice_ar[$i]."</br>";
					echo $sinfo[$i]."</br>";
				}
			}else{
				echo $sinfo;
			}
		?>
		</p>

		<p>DataPaths</br>
		<?php echo $datapaths;?>
		</p>

		<p>Links</br>
		<?php echo $links;?>
		</p>

		<p>Datapath Info</br>
		<?php
			if(is_array($dinfo)){
				for($i = 0; $i<count($datapath_ar);$i++){
					echo $datapath_ar[$i]."</br>";
					echo $dinfo[$i]."</br>";
				}
			}else{
				echo $dinfo;
			}
		?>
		</p>

		<p>Slice Stats</br>
		<?php
			if(is_array($sstats)){
				for($i = 0; $i<count($slice_ar);$i++){
					echo $slice_ar[$i]."</br>";
					echo $sstats[$i]."</br>";
				}
			}else{
				echo $sstats;
			}
		?>
		</p>

		<p>Datapath Stats</br>
		<?php
			if(is_array($dstats)){
				for($i = 0; $i<count($datapath_ar);$i++){
					echo $datapath_ar[$i]."</br>";
					echo $dstats[$i]."</br>";
				}
			}else{
				echo $dstats;
			}
		?>
		</p>

		<p>Flowvisor Health</br>
		<?php echo $fvhealth;?>
		</p>

		<p>Slice Health</br>
		<?php
			if(is_array($shealth)){
				for($i = 0; $i<count($slice_ar);$i++){
					echo $slice_ar[$i]."</br>";
					echo $shealth[$i]."</br>";
				}
			}else{
				echo $shealth;
			}
		?>
		</p>

		<p><input type="button" id="back" value="Back" onclick = "location.href = 'index.php?source=menu'"/></p>

	</body>
</html>
