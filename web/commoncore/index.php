<?php
	
	//get some files
	include_once('lib/security.php');
	include_once('lib/ParsetoDB.php');
	include_once('lib/Printjson.php');
	
	//get prepared to print soem data for debugging
	$printjson = new Printjson();
	$dbaction = new ParsetoDB();
	
	//// --- get some data
	$component = $_SERVER['QUERY_STRING'];//get which component we are parsing
		if(trim($component) == "" ){$component='math';}
		if($component != "math" && $component != "ela"){die("whoa -- weird component:$component");}
	
	if($component == "math"){
		//ENGLISH
		$json = file_get_contents("./commoncore-json/commoncore-math-D10003FC.json");
		echo "loaded MATH json<br>";	
	}else{
		//MATH
		$json = file_get_contents("./commoncore-json/commoncore-ela-D10003FB.json");	
		echo "loaded ELA json<br>";
	}//end if

	//adjust json data	
	$json_array = json_decode($json, TRUE);


	$printjson->print_creativecommonslicense();
?>

<html>
    <head>
        <title>standards.trails.by - common core parsing</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
        
        <style type="text/css">
        	body{padding:5px;padding-left: 20px;}
        	.dbfield{min-width:200px;display: inline;font-weight: bold;}
        	.dbvalue{width:600px;display: inline;}
        	.children-wrapper{width:800px;margin-left: 20px;background-color: #eee;}
        	.child{margin-left: 20px;border-bottom: 3px solid #fff;background-color: #ddd;}
        	.leaf{background-color:greenyellow;}
        </style>        
	</head>
	
	<body>
	
	<?php
	echo "<h2>common core standard: $component<h2>";
	$identity = 0;

	//START MASTER FOREACH
	foreach( $json_array as $key=>$entity){
		echo "<h3>--- entity ".$identity++."--</h3>";
		
		// id, asn_identifier,text
		$printjson->id_entifier_text($entity);
			
			//ADD TO DB!
			//$dbaction->addentity($entity);
			if( 1 ){ echo "<h4>OFF: dbaction->addentity()</h4>"; }
			
		// dcterms_description, asn_statementLabel
		$printjson->literalslanguages($entity);
		
		// asn_authorityStatus, dcterms_language, asn_indexingStatus, dcterms_subject		
		$printjson->uriprefables($entity);
		
		// localsubject
		$printjson->localsubject($entity);
		
		// cls
		$printjson->clsornot($entity);
		
		// childrens
		$printjson->childerator($entity);
		
		
		
	}//end MASTER foreach
	
	?>
	</body>
<html>       