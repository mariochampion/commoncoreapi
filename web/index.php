<?php

	//get some files
	include_once('commoncore/lib/security.php');
	include_once('commoncore/lib/Printjson.php');
	
	//get prepared to print some data for debugging
	$printjson = new Printjson();

	//print the instructions
	$printjson->print_q_error();

?>