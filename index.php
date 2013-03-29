<?php
  ini_set('display_errors', 'On');
//	include("object.php");
	include("fv_iface.php");	
?>

<html><body><h1>It works!</h1>
	<p>This is the default web page for this server.</p>
	<p>The web server software is running but no content has been added, yet!!</p>
	<?php
		exec("pgrep gedit", $output, $return);
		if ($return == 0) {
		    echo "Ok, process is running<br>\n";
		}

		//$test = new test;
		//$test->do_test();


		$fv_test = new fv_iface;
		var_dump($fv_test->createSlice("test","tcp:6633","octopusx@o2.pl","pass","exact",false,-1,-1,true));
	?><br>
	<?
		var_dump($fv_test->getSliceList());
	?><br>
	<?
		var_dump($fv_test->updateSlice("test",null,6634,"octopusx@o2.pl",null,null,null,null,null));
	?><br>
	<?
		var_dump($fv_test->getSliceList());
	?><br>
	<?
		var_dump($fv_test->deleteSlice("test"));

	?>
</body></html>
