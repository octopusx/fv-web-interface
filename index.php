<?php
	ini_set('display_errors', 'On');
?>




<?php

	include_once("controller.php");
	$controller = new Controller();

	$controller::action($_POST);

?>

