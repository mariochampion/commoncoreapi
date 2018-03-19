<?php
	error_reporting(0);
	//get some files
	include_once('lib/security.php');
	include_once('lib/ParsetoDB.php');
	include_once('lib/Printjson.php');
	
	//get prepared to print some data for debugging
	$printjson = new Printjson();
	$dbaction = new ParsetoDB();
	
	//clean the get vars
	$_CLEAN['GET'] = $dbaction->clean($_GET); 	

	//set up params
	$senderror = null;
	
	if( isset($_CLEAN['GET']['f']) ){
		$format = "array";
	}else{
		$format = null;
	}//end if
	
	
	if( isset($_CLEAN['GET']['c']) ){
		$component = $_CLEAN['GET']['c'];
		$component = mysql_real_escape_string($component);
		$component = trim($component);
		if($component == ""){$senderror = true;}
	}else{
		$senderror = true;
	}//end if	
	
	if( isset($_CLEAN['GET']['k']) ){		
		$keywords = $_CLEAN['GET']['k'];
		$keywords = mysql_real_escape_string($keywords);
		$keywords = trim($keywords);
	}else{
		$keywords = "";
	}//end if
	if($keywords =="allthewords"){$keywords="";}
	
	if( isset($_CLEAN['GET']['g']) ){
		$edulevels = $_CLEAN['GET']['g'];
		$edulevels = rtrim($edulevels, ',');
		if($edulevels=='all'){$edulevels="k,1,2,3,4,5,6,7,8,9,10,11,12";}
		$edulevels = mysql_real_escape_string($edulevels);
		//allow for k in sql's IN() clause
		$edulevels_parts = explode(',',$edulevels);
		$edulevels = "";
		foreach( $edulevels_parts as $edulevels_part){
			if($edulevels_part=="k"){$edulevels_part="'k'";}
			$edulevels .= trim($edulevels_part).",";
		}//end foreach
		$edulevels = rtrim($edulevels, ',');
	}else{
		$edulevels = "'k',1,2,3,4,5,6,7,8,9,10,11,12";
	}//endif

		
	if($senderror){	
		$printjson->print_q_error();
	}//end if


	//START ON ARRAY
	$allrows = array();	
	$allrows['component'] = $component;
	$allrows['keywords'] = $keywords;
	$allrows['education levels'] = $edulevels;	

	$qry = "SELECT e.identity, e.url_final, e.id, e.asn_identitifier, e.text, e.asn_statementNotation, e.asn_altStatementNotation, u.uri as dcterms_educationLevel
	FROM cc_entities e, cc_entitytoedulevels edu, cc_uripreflabels u
	WHERE e.component='$component' AND e.text LIKE '%$keywords%' AND u.prefLabel in ($edulevels) AND e.identity=edu.identity AND u.id=edu.iduripref GROUP BY e.identity";
	if( 0 ){ echo "<br>qry<pre>";print_r($qry);echo "<br>"; }
	$rslt = mysql_query($qry);
	
	//qk log for analysis later
	$allrows_json = json_encode($allrows);
	$allrows_json = mysql_real_escape_string($allrows_json);
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
	    $remote_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	    $remote_ip = $_SERVER['REMOTE_ADDR'];
	}
	$datetime = date("Y-m-d H:i:s");
	$qry_log = "INSERT INTO access_log VALUES (NULL, '$remote_ip', '$allrows_json','$datetime' )";
	$rslt_log = mysql_query($qry_log);
	
	
	if(!$rslt){
		$printjson->print_q_error();
	}else{
		
		if(mysql_num_rows($rslt) > 0){
			$x = 0;
			while($row = mysql_fetch_assoc($rslt)){
				$allrows['standards'][$x] = $row;
							
				$x++;
			}//end while
		}else{
			
			$allrows['standards'] = array();
					
		}//end if
		
		if( $format=="array" ){
			echo "<pre>";print_r($allrows);
		}else{
			echo (json_encode($allrows));
		}	
		
		
	}//end if


