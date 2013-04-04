<html>
	<head></head>
	<body>
		<h3>Flowvisor Configuration Tool</h3>
		<h4>FlowVisor Status</h4>
		<h5>Config Info</h5>

		<p>Slices</br>
		<?php echo $slices; ?>
		</p>

		<p>FlowSpaces</br>
		<?php
			for($i = 0; $i<count($slice_ar);$i++){
				echo $slice_ar[$i]."</br>";
				echo $flowspaces[$i]."</br>";
			}
		 ?>
		</p>

		<p>Configuration Info Per Slice</br>
		<?php
			for($i = 0; $i<count($slice_ar);$i++){
				echo $slice_ar[$i]."</br>";
				echo $config[$i]."</br>";
			}
		?>
		</p>

		<p>Version Info</br>
		<?php echo $version;?>
		</p>

		<h5>Monitoring Info</h5>

		<p>Slice Details</br>
		<?php
			for($i = 0; $i<count($slice_ar);$i++){
				echo $slice_ar[$i]."</br>";
				echo $sinfo[$i]."</br>";
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
			for($i = 0; $i<count($datapath_ar);$i++){
				echo $datapath_ar[$i]."</br>";
				echo $dinfo[$i]."</br>";
			}
		?>
		</p>

		<p>Slice Stats</br>
		<?php
			for($i = 0; $i<count($slice_ar);$i++){
				echo $slice_ar[$i]."</br>";
				echo $sstats[$i]."</br>";
			}
		?>
		</p>

		<p>Datapath Stats</br>
		<?php
			for($i = 0; $i<count($datapath_ar);$i++){
				echo $datapath_ar[$i]."</br>";
				echo $dstats[$i]."</br>";
			}
		?>
		</p>

		<p>Flowvisor Health</br>
		<?php echo $fvhealth;?>
		</p>

		<p>Slice Health</br>
		<?php
			for($i = 0; $i<count($slice_ar);$i++){
				echo $slice_ar[$i]."</br>";
				echo $shealth[$i]."</br>";
			}
		?>
		</p>

		<p><input type="button" id="back" value="Back" onclick = "location.href = 'index.php?source=menu'"/></p>

	</body>
</html>
