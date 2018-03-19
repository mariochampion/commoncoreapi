<?php
include_once('../security.php');
?>


<html>
    <head>
        <title>standards.trails.by - common core showjson</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
	</head>
	
	<body>
	<?php
	//get some data
	$thiskey = $_SERVER['QUERY_STRING'];
	if(trim($thiskey) == "" ){$thiskey='math';}
	
	if($thiskey == "ela"){
		//ENGLISH
		$json = file_get_contents("./commoncore-json/commoncore-ela-D10003FB.json");	
		echo "loaded ELA json<br>";	
	}else{
		//MATH
		$json = file_get_contents("./commoncore-json/commoncore-math-D10003FC.json");	
		echo "loaded MATH json<br>";	
	}//end if
	echo "<h2>common core standard: $thiskey<h2>";
	
	$json_array = json_decode($json, TRUE);
	if( 1 ){ echo "<br>json<pre>";print_r($json_array);echo "<br>";die(); }
	
	
	?>
	</body>
<html>       