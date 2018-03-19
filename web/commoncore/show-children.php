<?php
	
	//get some files
	include_once('lib/security.php');
	include_once('lib/ParsetoDB.php');
	include_once('lib/Printjson.php');
	
	//get prepared to print soem data for debugging
	$printjson = new Printjson();
	$dbaction = new ParsetoDB();
?>	
	
<html>
<head>
</head>
<body style="font-size:10px;padding:5px;font-family:Trebuchet MS;">	
	
	
<?	
	//// --- get some data
	$component = $_SERVER['QUERY_STRING'];//get which component we are parsing
		if(trim($component) == "" ){$component='math';}
		if($component != "math" && $component != "ela"){die("whoa -- weird component:$component");}

	$qry = "SELECT e.identity FROM cc_entities e WHERE e.component='$component'";
	$rslt = mysql_query($qry);
	
	$identity = mysql_result($rslt, 0 ,"identity");




	
