<html>
	<head>
		<script>
			var choice = 0;
			
			function submit(){

				var form = document.createElement("form");
				form.setAttribute("method", "get");
				form.setAttribute("action", "index.php");

				var fieldA = document.createElement("input");
				fieldA.setAttribute("type", "hidden");
				fieldA.setAttribute("name", "source");
				fieldA.setAttribute("value", "load");
				form.appendChild(fieldA);
				var fieldB = document.createElement("input");
				fieldB.setAttribute("type", "hidden");
				fieldB.setAttribute("name", "xml");
				fieldB.setAttribute("value", choice);
				form.appendChild(fieldB);
				
				document.body.appendChild(form);
				form.submit();
			}
		</script>
	</head>
	<body>

		<h3>Flowvisor Configuration Tool</h3>
		<h4>FlowVisor Configuration Manager</h4>

		<h5>Configuration list</h5>

		<form>
		<?php
			if(is_array($file_list)){
				for($i = 0; $i<count($file_list); $i++){
					echo "<input type=\"radio\" name=\"file\" value=\"";
					echo $i;
					echo "\" ";
					if($i==0){echo " checked ";}
					echo "onclick=\"choice=this.value\"";
					echo ">";
					echo $file_list[$i];
					?><br><?php
				}
			}else{
				echo "No Files Found";
			}
		?>
		</form>

		<p><input type="submit" id="load" value="Load" onclick="submit()"/></p>
		<p><input type="submit" id="back" value="Back" onclick = "location.href = 'index.php?source=menu'"/></p>

	</body>
</html>
