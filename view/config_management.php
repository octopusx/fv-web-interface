<html>
	<head></head>
	<body>

		<h3>Flowvisor Configuration Tool</h3>
		<h4>FlowVisor Configuration Manager</h4>

		<h5>Configuration list</h5>

		<form action="">
		<?php
			if(is_array($file_list)){
				for($i = 0; i<count($file_list);$i++){
					echo "<input type=\"radio\" name=\"file\" value=\"".$i."\">".$file_list."<\br>";
				}
			}else{
				echo $file_list;
			}
		?>
		</form>

	</body>
</html>
