<?php
	
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
	
	
	if( isset($_CLEAN['GET']['u']) ){
		$urlfinal = $_CLEAN['GET']['u'];
		$urlfinal = mysql_real_escape_string($urlfinal);
		$urlfinal = trim($urlfinal);
		if($urlfinal == ""){$senderror = true;}
	}else{
		$senderror = true;
	}//end if	
	
		
		
	if($senderror){	
		$printjson->print_u_error();
	}//end if


	//START ON ARRAY
	$allrows = array();	
	$singlestandard['url_final'] = $urlfinal;

	$qry = "SELECT e.identity, e.component, e.url_final, e.text, e.asn_statementNotation FROM cc_entities e WHERE e.url_final='$urlfinal'";
	$rslt = mysql_query($qry);
	$num = mysql_num_rows($rslt);
	if($num>0){
		
		$singlestandard['valid'] = "true";
		
		while($allrows = mysql_fetch_assoc($rslt)){
			//get the bridge table data
			
			///NOW ADD THE ONE to MANY TABLE DATA
			$allrows['dcterms_educationLevel'] = $dbaction->getedulevels_byIDentity_reduced($allrows['identity']);
			$allrows['skos_exactMatch'] = $dbaction->getskosexactmatch_byIDentity_reduced($allrows['identity']);
			//$allrows['asn_localSubject'] = $dbaction->getlocalsubjects_byIDentity($allrows['identity']);
			//$allrows['asn_comment'] = $dbaction->getasncomment_byIDentity($allrows['identity']);
		
			//put in new var
			$singlestandard['standard'] = $allrows;			
		}//end while

	}else{		
		
		$singlestandard['valid'] = "false";
		
	}//end if

	if( $format=="array" ){
		echo "<pre>";print_r($singlestandard);
	}else{
		echo (json_encode($singlestandard));
	}	
