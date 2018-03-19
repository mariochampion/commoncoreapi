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
        <title>standards.trails.by - database output - <?php echo $component; ?></title>
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
	$qry = "SELECT e.* FROM cc_entities e WHERE e.component='$component'";
	$rslt = mysql_query($qry);
	$num = mysql_num_rows($rslt);
	
	if($num>0){
		
		while($allrows = mysql_fetch_assoc($rslt)){
			
			//get the bridge table data
			
			foreach($allrows as $key=>$value){
				// LIT LANGS dcterms_description asn_statementLabel 
				if($key == "dcterms_description"){
					$datareturned = $dbaction->getliterallanguage_byIDliteral($value, 'dcterms_description');
					$allrows['dcterms_description'] = $datareturned;
				}//end if
				if($key == "asn_statementLabel"){
					$datareturned = $dbaction->getliterallanguage_byIDliteral($value, 'asn_statementLabel');
					$allrows['asn_statementLabel'] = $datareturned;
				}//end if
				
				//URIPREFs asn_authorityStatus  dcterms_language 	asn_indexingStatus 	dcterms_subject
				if($key == "asn_authorityStatus"){
					$datareturned = $dbaction->geturipref_byIDuripref($value, 'asn_authorityStatus');
					$allrows['asn_authorityStatus'] = $datareturned;
				}//end if
				if($key == "dcterms_language"){
					$datareturned = $dbaction->geturipref_byIDuripref($value, 'dcterms_language');
					$allrows['dcterms_language'] = $datareturned;
				}//end if
				if($key == "asn_indexingStatus"){
					$datareturned = $dbaction->geturipref_byIDuripref($value, 'asn_indexingStatus');
					$allrows['asn_indexingStatus'] = $datareturned;
				}//end if
				if($key == "dcterms_subject"){
					$datareturned = $dbaction->geturipref_byIDuripref($value, 'dcterms_subject');
					$allrows['dcterms_subject'] = $datareturned;
				}//end if
				
			}//end foreach
			
			///NOW ADD THE ONE to MANY TABLE DATA
			$allrows['dcterms_educationLevel'] = $dbaction->getedulevels_byIDentity($allrows['identity']);
			$allrows['skos_exactMatch'] = $dbaction->getskosexactmatch_byIDentity($allrows['identity']);
			$allrows['asn_localSubject'] = $dbaction->getlocalsubjects_byIDentity($allrows['identity']);
			$allrows['asn_comment'] = $dbaction->getasncomment_byIDentity($allrows['identity']);
			$allrows['children'] = $dbaction->getchildren_byIDentity($allrows['identity']);
			
			echo "<pre>";
			print_r($allrows);
			echo "</pre>";
		}//end while
		
		
		
		
		
	}//end if





	?>
	
	</body>
	</html>