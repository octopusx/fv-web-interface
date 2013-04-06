<html>
	<head></head>
	<body>
		<h3>Flowvisor Configuration Tool.</h3>
		<p>Loged in as: <?php echo $user;?></br>
		URL: <?php echo $address;?></p>

		<table border="0">
			<tr>
				<td>Display FlowVisor Status Information</td>
				<td><input type="button" id="status" value="Status" onclick = "location.href = 'index.php?source=status'"/></td>
			</tr>
			<tr>
				<td>Manually Configure FlowVisor</td>
				<td><input type="button" id="config" value="Configure" onclick = "location.href = 'index.php?source=config'"/></td>
			</tr>
			<tr>
				<td>Manage FlowVisor Configurations</td>
				<td><input type="button" id="config" value="Configure" onclick = "location.href = 'index.php?source=xml'"/></td>
			</tr>
		</table>
	
	</body>
</html>

