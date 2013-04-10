<html>
	<head>
	</head>
	<body>

		<h3>Flowvisor Configuration Tool</h3>
		<h4>FlowVisor Configuration Manager</h4>

		<h5>Configuration list</h5>

		<form action="">
		<?php
			if(is_array($file_list)){
//				echo count($file_list);
				for($i = 0; $i<count($file_list);$i++){
					echo "<input type=\"radio\" name=\"file\" value=\"";
					echo $i;
					if($i==0){echo " checked";}
					echo ">";
					echo $file_list[$i];
					?><br><?
				}
			}else{
				echo "No Files Found";
			}
		?>
		</form>

	</body>
</html>
