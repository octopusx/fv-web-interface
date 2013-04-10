<html>
	<head>
	</head>
	<body>

		<h3>Flowvisor Configuration Tool</h3>
		<h4>FlowVisor Configuration Manager</h4>

		<h5>Configuration list</h5>

		<form action="">
		<?php
			echo "dupa";
			if(is_array($file_list)){
				echo count($file_list);
				echo $file_list[0];
				for($i = 0; $i<count($file_list); $i++){
					echo "test";
				}
			}else{
				echo "No Files Found";
			}
		?>
		</form>

	</body>
</html>
