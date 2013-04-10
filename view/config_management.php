<html>
	<head>
		<script>
			function getSelection(){
				var ret = "'index.php?source=load&xml=";
				var choice = document.getElementsByName('file');
				for (var i = 0, length = choice.length; i < length; i++) {
					if (choice[i].checked) {
						ret = ret + radios[i].value +"'";
			        		return(ret);
					}
				}
			}
		</script>
	</head>
	<body>

		<h3>Flowvisor Configuration Tool</h3>
		<h4>FlowVisor Configuration Manager</h4>

		<h5>Configuration list</h5>

		<form action="">
		<?php
			if(is_array($file_list)){
				for($i = 0; $i<count($file_list); $i++){
					echo "<input type=\"radio\" name=\"file\" value=\"";
					echo $i;
					echo "\" ";
					if($i==0){echo " checked ";}
					echo ">";
					echo $file_list[$i];
					?><br><?php
				}
			}else{
				echo "No Files Found";
			}
		?>
		<input type="submit" id="load" value="Load" onclick = "location.href = <script>document.write(getSelection())</script>"/>
		</form>

		<p><input type="submit" id="back" value="Back" onclick = "location.href = 'index.php?source=menu'"/></p>

	</body>
</html>
