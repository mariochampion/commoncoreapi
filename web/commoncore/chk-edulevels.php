<?php
	
	//get some files
	include_once('lib/security.php');
	include_once('lib/ParsetoDB.php');
	include_once('lib/Printjson.php');
	
	//get prepared to print some data for debugging
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



?>

<html>
    <head>
        <title>standards.trails.by - common core parsing - edulevel - <?php echo $component; ?></title>
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
		
	$qrya = "SELECT e.identity, e.url_final FROM cc_entities e WHERE e.component='$component'";
	if( 0 ){ echo "<br>qrya $qrya<br>"; }
	$rslta = mysql_query($qrya);
	$numa = mysql_num_rows($rslta);
	$missing_array = array();
	
	if($rslta){
		$x = 0;
		while($row = mysql_fetch_assoc($rslta)){
			$thisidentity = $row['identity'];
			$url_final = $row['url_final'];
			$qry = "SELECT DISTINCT(edu.identity) FROM cc_entitytoedulevels edu WHERE edu.identity = $thisidentity";
			if( 0 ){ echo "<br>qry $qry<br>"; }
			$rslt = mysql_query($qry);
			$num = mysql_num_rows($rslt);
			if($num<1){
				
				$missing_array[$x]['identity'] = $thisidentity; 
				$missing_array[$x]['url_final'] = $url_final; 
				$x++;
			}//end if
	

		}//end while	
	}//end if


	echo "missing_array ";
	if( 1 ){ echo "<br><pre>";print_r($missing_array);echo "<br>";die(); }


	?>
	
	</body>
	</html>