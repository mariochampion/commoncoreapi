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

	$qry = "SELECT e.* FROM cc_entities e WHERE e.url_final='$urlfinal'";
	$rslt = mysql_query($qry);
	$num = mysql_num_rows($rslt);
	if($num>0){
		
		$singlestandard['valid'] = "true";
		
		while($allrows = mysql_fetch_assoc($rslt)){
			//get the bridge table data
			
			foreach($allrows as $key=>$value){
				//do some renaming
				if($key == "id"){
					$allrows['asn_uri'] = $value;
				}
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
