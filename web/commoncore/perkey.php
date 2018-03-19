<?php
include_once('../security.php');
?>

<html>
    <head>
        <title>standards.trails.by - common core parsing</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
	</head>
	
	<body>
	<?php
	
	$thiskey = $_SERVER['QUERY_STRING'];	
	$json = file_get_contents("./commoncore-json/commoncore-ela-D10003FB.json");$filejson="ela";
	//$json = file_get_contents("./commoncore-json/commoncore-math-D10003FC.json");$filejson="math";
	
	$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);
	
	$keycount = 0;

	//display (of sorts) starts here
	if(!$thiskey){echo "need k={keystring}";die();}else{echo "<h2>$filejson => $thiskey </h2>";}
	echo "<pre>";
	foreach ($jsonIterator as $key => $val) {
	    	
	    
		if($key == $thiskey){
			//print_r( $keycount++.". $key => $val<br>");
			print_r( $keycount++.". $key => $val: ". count($val)."<br>");
		}else{
			//nothing
		}//end if	    
		
		
		
	}//end foreach
	echo "</pre>";
	?>
	</body>




</html>      