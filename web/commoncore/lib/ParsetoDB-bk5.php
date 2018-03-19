<?php

////// DB functions to get the various compnents from the big JSON to relational mysql

class ParsetoDB {


	//// functions returns data for using old fashioned sql! lets see if i can do this after so much doctrine!
	public function __construct(){
		
		$this->data['dbdata']['host'] = "localhost";
		$this->data['dbdata']['user'] = "root";
		$this->data['dbdata']['pass'] = "allf0rplast1chang3rs";
		$this->data['dbdata']['database'] = "standards";
		$this->data['dbdata']['connection'] = mysql_connect($this->data['dbdata']['host'],$this->data['dbdata']['user'],$this->data['dbdata']['pass']);
		$this->data['dbdata']['mysql_select'] = @mysql_select_db($this->data['dbdata']['database']) or die( "Unable to select database");
		echo "<!-- ParsetoDB__construct() -->";
		
	}//end function
	
	
	
	//// functions returns _____
	//// function expects _____
	public function addentity($thisentity){
		
		//check for valid ELA r MATH components
		$component = $this->checkforcomponent();
		
		//if( $this->chkforexisting($thisentity) ){
		if( 0 ){
			//dont add - already exists
			echo "<!-- dupe for ". $thisentity['id']." -->";
		}else{

			//else make new one.			
			$id = $thisentity['id'];
			$id = mysql_real_escape_string($id);
			
			$urlfinal_parts = explode("http://asn.jesandco.org/resources",$id);//TODO: MAGIC VALUES!!!
			$urlfinal = $urlfinal_parts[1];
			$urlfinal = ltrim($urlfinal, '/');
			if( trim($urlfinal)==""){die('urlfinal is blank! couldnt be....');}
			$urlfinal = mysql_real_escape_string($urlfinal);
			
			$asn_identitifier = "http://purl.org/ASN/resources/".$urlfinal;//TODO: MAGIC VALUES!!!
			$asn_identitifier = mysql_real_escape_string($asn_identitifier);
			
			$text = $thisentity['text'];
			$text = mysql_real_escape_string($text);

			if( isset($thisentity['cls']) ){$cls = $thisentity['cls'];
			}else{$cls = NULL;}//end if
				
			if( isset($thisentity['leaf']) ){$leaf = 1;
			}else{$leaf = NULL;}//end if
			
			if( isset($thisentity['asn_statementNotation']) ){
				$asn_statementNotation = $thisentity['asn_statementNotation'];
				$asn_statementNotation = mysql_real_escape_string($asn_statementNotation);
			}else{$asn_statementNotation = NULL;}//end if
			
			if( isset($thisentity['asn_altStatementNotation']) ){
				$asn_altStatementNotation = $thisentity['asn_altStatementNotation'];		
				$asn_altStatementNotation = mysql_real_escape_string($asn_altStatementNotation);
			}else{$asn_altStatementNotation = NULL;}//end if
			
			if( isset($thisentity['asn_listID']) ){
				$asn_listID = $thisentity['asn_listID'];		
				$asn_listID = mysql_real_escape_string($asn_listID);
			}else{$asn_listID = NULL;}//end if
			
			if( isset($thisentity['dcterms_description']) ){
				$literal = $thisentity['dcterms_description']['literal'];
				$language = $thisentity['dcterms_description']['language'];
				$etype = 'dcterms_description';
				$dcterms_description = $this->get_id_literallanguage($etype, $literal, $language);
			}else{die("<h3>$urlfinal: dcterms_description problem</h3>");}//end if

			if( isset($thisentity['asn_authorityStatus']) ){
				$uri = $thisentity['asn_authorityStatus']['uri'];
				$prefLabel = $thisentity['asn_authorityStatus']['prefLabel'];
				$etype = 'asn_authorityStatus';
				$asn_authorityStatus = $this->get_id_uripref($etype, $uri, $prefLabel);
			}else{die("<h3>$urlfinal: asn_authorityStatus problem</h3>");}//end if
			
			if( isset($thisentity['dcterms_language']) ){
				$uri = $thisentity['dcterms_language']['uri'];
				$prefLabel = $thisentity['dcterms_language']['prefLabel'];
				$etype = 'dcterms_language';
				$dcterms_language = $this->get_id_uripref($etype, $uri, $prefLabel);
			}else{die("<h3>$urlfinal: dcterms_language problem</h3>");}//end if
			
			if( isset($thisentity['asn_indexingStatus']) ){
				$uri = $thisentity['asn_indexingStatus']['uri'];
				$prefLabel = $thisentity['asn_indexingStatus']['prefLabel'];
				$etype = 'asn_indexingStatus';
				$asn_indexingStatus = $this->get_id_uripref($etype, $uri, $prefLabel);
			}else{die("<h3>$urlfinal: asn_indexingStatus problem</h3>");}//end if
			
			if( isset($thisentity['dcterms_subject']) ){
				$uri = $thisentity['dcterms_subject']['uri'];
				$prefLabel = $thisentity['dcterms_subject']['prefLabel'];
				$etype = 'dcterms_subject';
				$dcterms_subject = $this->get_id_uripref($etype, $uri, $prefLabel);
			}else{die("<h3>$urlfinal: dcterms_subject problem</h3>");}//end if

			
			
			//// DB ACTION
			$qrye = "SELECT a.id FROM cc_entities a WHERE a.url_final = '$urlfinal'";
			$rslte = mysql_query($qrye);
			$nume = mysql_num_rows($rslte);
			
			if( $nume > 0 ){
				$qry = "UPDATE cc_entities SET component='$component',url_final='$urlfinal', id='$id', asn_identitifier='$asn_identitifier', text='$text', dcterms_description='$dcterms_description', asn_authorityStatus='$asn_authorityStatus', dcterms_language='$dcterms_language', asn_indexingStatus='$asn_indexingStatus', dcterms_subject='$dcterms_subject', cls='$cls', leaf='$leaf' ,asn_statementNotation='$asn_statementNotation', asn_altStatementNotation='$asn_altStatementNotation', asn_listID='$asn_listID' WHERE url_final = '$urlfinal' ";

			}else{

				$qry = "INSERT INTO cc_entities VALUES ('NULL', '$component','$urlfinal', '$id', '$asn_identitifier', '$text', '$dcterms_description', '$asn_authorityStatus', '$dcterms_language', '$asn_indexingStatus', '$dcterms_subject', '$cls', '$leaf' ,'$asn_statementNotation', '9999999', '$asn_altStatementNotation', '$asn_listID' )";

			}//end if
			
			$rslt = mysql_query($qry);
			
			
			if($rslt){
				//true
				if( 1 ){ echo "<br>WIN: $qry<br>";}
			   	return true;
			}else{
				//false
			    //return false;
			    if( 1 ){ echo "<br>FAILED: $qry<br>"; die(); }
			}//end if
		
		}//end if
		
		
		
	}//end function
	
	
	//// functions returns _____
	//// function expects _____
	public function chkforexisting($thisentity){
	
		//qry for existing in cc_entities based on "id"
		$id = $thisentity['id'];
		$id = mysql_real_escape_string($id);
		$qry = "SELECT e.id FROM cc_entities e WHERE e.id='$id'";
		$rslt = mysql_query($qry);
		$num = mysql_num_rows($rslt);
		
		if( $num > 0 ){
			//true
		   	return true;
		}else{
			//false
		    return false;
		}//end if
		
		
	
	}//end function
	
	
	
	//// functions returns $component
	public function checkforcomponent(){
		
		$component = $_SERVER['QUERY_STRING'];//get which component we are parsing
		if(trim($component) == "" ){$component='math';}
		if($component != "math" && $component != "ela"){die("whoa -- weird component:$component");}
		
		return $component;
	}//end function
	
	
	
	//// functions returns true or level
	public function chkforexisting_relatediduripreflabel($identity, $iduripref, $tabletocheck ){
		
		
		if( 1 ){ echo "<br>tabletocheck $tabletocheck<br>"; }
		
		//qry for existing record based on "$identity, $iduripref"
		$identity = mysql_real_escape_string($identity);
		$iduripref = mysql_real_escape_string($iduripref);		
		$qry = "SELECT e.id FROM $tabletocheck e WHERE e.identity='$identity' AND e.iduripref='$iduripref'";
		$rslt = mysql_query($qry);
		$num = mysql_num_rows($rslt);
		
		if( $num > 0 ){
			//exists
		   	return true;
		}else{
			//does not exist
		    return false;
		}//end if
	
	}//end function



	//// functions returns _____
	//// function expects _____
	public function chkforexisting_relatedliterallanguage($identity, $idliterallanguage, $tabletocheck){
	
		if( 1 ){ echo "<br>RELATED LITLANG tabletocheck $tabletocheck<br>"; }
			
			//qry for existing record based on "$identity, $idliterallanguage"
			$identity = mysql_real_escape_string($identity);
			$idliterallanguage = mysql_real_escape_string($idliterallanguage);		
			$qry = "SELECT e.id FROM $tabletocheck e WHERE e.identity='$identity' AND e.idliterallanguage='$idliterallanguage'";
			$rslt = mysql_query($qry);
			$num = mysql_num_rows($rslt);
			
			if( $num > 0 ){
				//exists
			   	return true;
			}else{
				//does not exist
			    return false;
			}//end if

	
	
	}//end function


	//// functions returns true (if exists) or false (if not)
	public function chkforexisting_childparent($component, $idchild, $idparent){
		
		$component = mysql_real_escape_string($component);
		$idchild = mysql_real_escape_string($idchild);
		$idparent = mysql_real_escape_string($idparent);		
		$qry = "SELECT c.id FROM cc_children c WHERE c.component='$component' AND c.idchild='$idchild' AND c.idparent='$idparent'";
		if( 1 ){ echo "<br>chkforexisting_childparent qry $qry<br>"; }
		$rslt = mysql_query($qry);
		$num = mysql_num_rows($rslt);
		
		if( $num > 0 ){
			//exists
			if( 1 ){ echo "<h4>EXISTS</h4>"; }
		   	return true;
		}else{
			//does not exist
			if( 1 ){ echo "<h4>NO EXISTS</h4>"; }
		    return false;
		}//end if


	
	}//end function

	
	
	
	
	
	//// returns children entities (RECURSIVE)
	public function findthechilds($thisentity, $importantkey){
		
		$dbaction = new ParsetoDB();
		if( 1 ){ echo "<br>3 importantkey $importantkey<br>"; }
		if(isset($thisentity['children'])){
		if( 1 ){ echo "<br>4<br>"; }
			$numchildrens = count($thisentity['children']);
			if($numchildrens > 0){
				if( 1 ){ echo "<br>5<br>"; }
					foreach($thisentity['children'] as $child){
					
						//ADD TO DB!
						if($importantkey == "dcterms_educationLevel"){
							if( 1 ){ echo "<br>dcters<br>"; }
							$this->process_edulevel($child['dcterms_educationLevel'], $child['id']);			
						}//end if
						
						if($importantkey == "skos_exactMatch"){
							//if(isset($entity['skos_exactMatch'])){
								if( 1 ){ echo "<br>go skos<br>"; }
								$this->process_skos_exactMatch($child['skos_exactMatch'], $child['id']);			
							//}//end if	
						}//end if
						
						if($importantkey == "asn_localSubject"){
							//if(isset($entity['skos_exactMatch'])){
								if( 1 ){ echo "<br>go asn_localSubject<br>"; }
								$this->process_asnlocalsubject($child['asn_localSubject'], $child['id']);			
							//}//end if	
						}//end if
						
						if($importantkey == "asn_statementLabel"){
							//if(isset($entity['skos_exactMatch'])){
								if( 1 ){ echo "<br>go asn_statementLabel<br>"; }
								$this->process_asnstatementlabel($child['asn_statementLabel'], $child['id']);			
							//}//end if	
						}//end if
						
						//be recursive
						////be recursive
						if( 1 ){ echo "<h3>recurse!</h3>"; }
						$this->findthechilds($child, $importantkey);			

					}//end foreach
				
			}//end if
			
		}//end if isset children	
	
	}//end function

	
	//// functions returns identity (this is a unique autoincrementing id)
	//// function expects entity-id (in teh common core json, this is a url)
	public function getidentityfromid($entity_id){
		
		$id = mysql_real_escape_string($entity_id);
		$qry = "SELECT e.identity FROM cc_entities e WHERE e.id='$id' LIMIT 1";
		$rslt = mysql_query($qry);
		$identity = mysql_result($rslt, 0 ,"identity");
		if( 1 ){ echo "<br>$id = $identity<br>";}
		if(trim($identity)==""){die("nooo! no identity: SELECT e.identity FROM cc_entities e WHERE e.id='$id' LIMIT 1 = $identity");}

		return $identity;
	
	}//end function
	
	
	
	
	
	
	//// function expects dcterms_educationLevel and entity's id
	public function process_edulevel($entity_edulevels, $entity_id){
		
		//get base vars
		$identity = $this->getidentityfromid($entity_id);	
		if( 1 ){ echo "<h3>--- entity: $entity_id ---</h3><pre>";print_r($entity_edulevels);echo "</pre><br>";}
		
		$entity_edulevels_count = count($entity_edulevels);		
		foreach($entity_edulevels as $key=>$edulevel){
			
			if(count($edulevel) == 2){
				if( 0 ){ echo "<br>count == 2<br>"; }
				$edu_uri =  $edulevel['uri'];
				$edu_uri = mysql_real_escape_string($edu_uri);
				$edu_label = $edulevel['prefLabel'];				
				$edu_label = mysql_real_escape_string($edu_label);

			}else{
				if( 0 ){ echo "<br>count NOT 2<br>"; }
				$keycount = count($key);
				if( 1 ){ echo "<br>count key = $key<br>"; }
				$edu_uri =  $entity_edulevels['uri'];
				$edu_uri = mysql_real_escape_string($edu_uri);				
				$edu_label = $entity_edulevels['prefLabel'];				
				$edu_label = mysql_real_escape_string($edu_label);
			}//end if
			
			//set up qrys now
			$qryb = "SELECT u.id FROM cc_uripreflabels u WHERE u.etype = 'dcterms_educationLevel' AND u.uri = '$edu_uri' AND u.prefLabel = '$edu_label' LIMIT 1";
			if( 1 ){ echo "<br>qryb<pre>";print_r($qryb);echo "</pre>"; }
			$rsltb = mysql_query($qryb);
			
			$iduri = null;
			if($rsltb){
				//GET ID
				$iduri = mysql_result($rsltb, 0, 'id');
				
			}else{
				//ADD TO URI PREFLABEL
				$qryi = "INSERT INTO cc_uripreflabels VALUES (NULL, 'dcterms_educationLevel', '$edu_uri', '$edu_label')";
				$rslti = mysql_query($qryi);
				if(!$rslti){die('noooo! didnt insert new cc_uripreflabels/dcterms_educationLevel');}
				//now go get id again
				$qryb2 = "SELECT u.id FROM cc_uripreflabels u WHERE u.etype = 'dcterms_educationLevel' AND u.uri = '$edu_uri' AND u.prefLabel = '$edu_label' LIMIT 1";
				if( 1 ){ echo "<br>qryb2<pre>";print_r($qryb2);echo "</pre>"; }
				$rsltb2 = mysql_query($qryb2);
				$numb2 = mysql_num_rows($rsltb2);
				if($numb2>0){$iduri = mysql_result($rsltb2, 0, 'id');}

			}//end if
			
			
			//now add to cc_entitytoedulevels
			if($iduri){
				
				//check for existing record
				if( !$this->chkforexisting_relatediduripreflabel($identity, $iduri, 'cc_entitytoedulevels' ) ){
					
					$qryc = "INSERT INTO cc_entitytoedulevels VALUES (NULL, $identity, $iduri)";
					$rsltc = mysql_query($qryc);
					if( $rsltc ){ echo "&nbsp;&nbsp;&nbsp;SUCCESS: $qryc <br>"; }else{'did NOT insert<br>';}
					
				}else{
					if( 1 ){ echo "<br>DUPE for (identity,iduripref) $identity, $iduri<br>"; }
				}//end if
				
				
			}else{
				//soemthing went wrong!
				die("<h3>2. problem at  process_edulevel</h3>");
			}//end if
			
		}//end foreach
		
		
		return true;

	}//end function
	
	
	
	
	
	
	//// functions returns _____
	//// function expects _____
	public function process_skos_exactMatch($entity_skosmatches, $entity_id){
	
		//get base vars
		$identity = $this->getidentityfromid($entity_id);	
		if( 1 ){ echo "<h3>--- entity: $entity_id ---</h3><pre>";print_r($entity_skosmatches);echo "</pre><br>";}
		
		$entity_skosmatches_count = count($entity_skosmatches);		
		if( 1 ){ echo "<br>entity_skosmatches_count $entity_skosmatches_count<br>"; }
		if($entity_skosmatches_count > 0){
			foreach($entity_skosmatches as $key=>$edulevel){
				
				if(count($edulevel) == 2){
					if( 1 ){ echo "<br>count == 2<br>"; }
					$edu_uri =  $edulevel['uri'];
					$edu_uri = mysql_real_escape_string($edu_uri);
					$edu_label = $edulevel['prefLabel'];
					$edu_label = mysql_real_escape_string($edu_label);				
	
				}else{
					if( 1 ){ echo "<br>count NOT 2<br>"; }
					$keycount = count($key);
					if( 1 ){ echo "<br>count key = $key<br>"; }
					$edu_uri =  $entity_skosmatches['uri'];
					$edu_uri = mysql_real_escape_string($edu_uri);
					$edu_label = $entity_skosmatches['prefLabel'];
					$edu_label = mysql_real_escape_string($edu_label);				
				}//end if
				
				//set up qrys now
				$qryb = "SELECT u.id FROM cc_uripreflabels u WHERE u.etype = 'skos_exactMatch' AND u.uri = '$edu_uri' AND u.prefLabel = '$edu_label' LIMIT 1";
				if( 1 ){ echo "<br>qryb<pre>";print_r($qryb);echo "</pre>"; }
				$rsltb = mysql_query($qryb);
				$numb = mysql_num_rows($rsltb);
				
				$iduri = null;
				if($numb > 0){
					//GET ID
					$iduri = mysql_result($rsltb, 0, 'id');
					
				}else{
					//ADD TO URI PREFLABEL
					$qryi = "INSERT INTO cc_uripreflabels VALUES (NULL, 'skos_exactMatch', '$edu_uri', '$edu_label')";
					$rslti = mysql_query($qryi);
					if(!$rslti){die('noooo! didnt insert new cc_uripreflabels/skos_exactMatch');}
					
					//now go get id again
					$qryb2 = "SELECT u.id FROM cc_uripreflabels u WHERE u.etype = 'skos_exactMatch' AND u.uri = '$edu_uri' AND u.prefLabel = '$edu_label' LIMIT 1";
					if( 1 ){ echo "<br>qryb2<pre>";print_r($qryb2);echo "</pre>"; }
					$rsltb2 = mysql_query($qryb2);
					$numb2 = mysql_num_rows($rsltb2);
					if($numb2>0){$iduri = mysql_result($rsltb2, 0, 'id');}
				}//end if
				
				
				//now add to cc_skosexactmatches
				if($iduri){
					
					//check for existing record
					if( !$this->chkforexisting_relatediduripreflabel($identity, $iduri, 'cc_skosexactmatches' ) ){
						
						$qryc = "INSERT INTO cc_skosexactmatches VALUES (NULL, $identity, $iduri)";
						$rsltc = mysql_query($qryc);
						if( $rsltc ){ echo "&nbsp;&nbsp;&nbsp;SUCCESS: $qryc <br>"; }else{'did NOT insert<br>';}
						
					}else{
						if( 1 ){ echo "<br>DUPE for (identity,iduripref) $identity, $iduri<br>"; }
					}//end if
					
					
				}else{
					//soemthing went wrong!
					die("<h3>2. problem at process skos_exactMatch</h3>");
				}//end if
				
			}//end foreach
		}//end if	
		
		return true;

	
	}//end function
	
	
	
	
	//// functions returns _____
	//// function expects _____
	public function process_asnlocalsubject($entity_localsubj, $entity_id){
	
		if( 1 ){ echo "<br>process_asnlocalsubject<br>"; }
		//get base vars
		$identity = $this->getidentityfromid($entity_id);	
		if( 1 ){ echo "<h3>--- entity: $entity_id ---</h3><pre>";print_r($entity_localsubj);echo "</pre><br>";}

		$entity_localsubj_count = count($entity_localsubj);		
		if( 1 ){ echo "<br>entity_localsubj_count $entity_localsubj_count<br>"; }
		if($entity_localsubj_count>0){
			echo "<br>DO DB MAGIC for $entity_id<br>";
		
			foreach($entity_localsubj as $key=>$edulevel){
				
				if(count($edulevel) == 2){
					if( 1 ){ echo "<br>count == 2<br>"; }
					$edu_uri =  $edulevel['literal'];
					$edu_uri = mysql_real_escape_string($edu_uri);
					$edu_label = $edulevel['language'];				
					$edu_label = mysql_real_escape_string($edu_label);
	
				}else{
					if( 1 ){ echo "<br>count NOT 2<br>"; }
					$keycount = count($key);
					if( 1 ){ echo "<br>count key = $key<br>"; }
					$edu_uri =  $entity_localsubj['literal'];
					$edu_uri = mysql_real_escape_string($edu_uri);
					$edu_label = $entity_localsubj['language'];
					$edu_label = mysql_real_escape_string($edu_label);
				}//end if
				
				//set up qrys now
				$qryb = "SELECT u.id FROM cc_literalslanguages u WHERE u.etype = 'asn_localSubject' AND u.literal = '$edu_uri' AND u.language = '$edu_label' LIMIT 1";
				if( 1 ){ echo "<br>qryb<pre>";print_r($qryb);echo "</pre>"; }
				$rsltb = mysql_query($qryb);
				$numb = mysql_num_rows($rsltb);
				
				$iduri = null;
				if($numb > 0){
					//GET ID
					$iduri = mysql_result($rsltb, 0, 'id');
					
				}else{
					//ADD TO cc_literalslanguages
					$qryi = "INSERT INTO cc_literalslanguages VALUES (NULL, 'asn_localSubject', '$edu_uri', '$edu_label')";
					$rslti = mysql_query($qryi);
					if(!$rslti){die('noooo! didnt insert new cc_literalslanguages/asn_localSubject');}
					
					//now go get id again
					$qryb2 = "SELECT u.id FROM cc_literalslanguages u WHERE u.etype = 'asn_localSubject' AND u.literal = '$edu_uri' AND u.language = '$edu_label' LIMIT 1";
					if( 1 ){ echo "<br>qryb2<pre>";print_r($qryb2);echo "</pre>"; }
					$rsltb2 = mysql_query($qryb2);
					$numb2 = mysql_num_rows($rsltb2);
					if($numb2>0){$iduri = mysql_result($rsltb2, 0, 'id');}
				}//end if
				
				
				//now add to cc_skosexactmatches
				if($iduri){
					
					//check for existing record
					if( !$this->chkforexisting_relatedliterallanguage($identity, $iduri, 'cc_entitytolocalsubjects' ) ){
						
						$qryc = "INSERT INTO cc_entitytolocalsubjects VALUES (NULL, $identity, $iduri)";
						$rsltc = mysql_query($qryc);
						if( $rsltc ){ echo "&nbsp;&nbsp;&nbsp;SUCCESS: $qryc <br>"; }else{'did NOT insert<br>';}
						
					}else{
						if( 1 ){ echo "<br>DUPE for (identity,idliteral) $identity, $iduri<br>"; }
					}//end if
					
					
				}else{
					//soemthing went wrong!
					die("<h3>2. problem at process_asnlocalsubject</h3>");
				}//end if
				
			}//end foreach
		
		}//end if
		
		
		
		
		
		return true;
	
	
	}//end function
	
	
	
	//// functions returns _____
	//// function expects _____
	public function process_asnstatementlabel($entity_localsubj, $entity_id){
	
		if( 1 ){ echo "<br>process_asnstatementlabel<br>"; }
		//get base vars
		$identity = $this->getidentityfromid($entity_id);	
		if( 1 ){ echo "<h3>--- entity: $entity_id ---</h3><pre>";print_r($entity_localsubj);echo "</pre><br>";}

		$entity_localsubj_count = count($entity_localsubj);		
		if( 1 ){ echo "<br>count asn_statementLabel $entity_localsubj_count<br>"; }
		
		if($entity_localsubj_count>0){
			echo "<br>DO DB MAGIC for $entity_id<br>";
		
			foreach($entity_localsubj as $key=>$edulevel){
				
				if(count($edulevel) == 2){
					if( 1 ){ echo "<br>count == 2<br>"; }
					$edu_uri =  $edulevel['literal'];
					$edu_uri = mysql_real_escape_string($edu_uri);
					$edu_label = $edulevel['language'];				
					$edu_label = mysql_real_escape_string($edu_label);
	
				}else{
					if( 1 ){ echo "<br>count NOT 2<br>"; }
					$keycount = count($key);
					if( 1 ){ echo "<br>count key = $key<br>"; }
					$edu_uri =  $entity_localsubj['literal'];
					$edu_uri = mysql_real_escape_string($edu_uri);
					$edu_label = $entity_localsubj['language'];
					$edu_label = mysql_real_escape_string($edu_label);
				}//end if
				
				//set up qrys now
				$qryb = "SELECT u.id FROM cc_literalslanguages u WHERE u.etype = 'asn_statementLabel' AND u.literal = '$edu_uri' AND u.language = '$edu_label' LIMIT 1";
				if( 1 ){ echo "<br>qryb<pre>";print_r($qryb);echo "</pre>"; }
				$rsltb = mysql_query($qryb);
				$numb = mysql_num_rows($rsltb);
				
				$iduri = null;
				if($numb > 0){
					//GET ID
					$iduri = mysql_result($rsltb, 0, 'id');
					
				}else{
					//ADD TO cc_literalslanguages
					$qryi = "INSERT INTO cc_literalslanguages VALUES (NULL, 'asn_statementLabel', '$edu_uri', '$edu_label')";
					$rslti = mysql_query($qryi);
					if(!$rslti){die('noooo! didnt insert new cc_literalslanguages/asn_statementLabel');}
					
					//now go get id again
					$qryb2 = "SELECT u.id FROM cc_literalslanguages u WHERE u.etype = 'asn_statementLabel' AND u.literal = '$edu_uri' AND u.language = '$edu_label' LIMIT 1";
					if( 1 ){ echo "<br>qryb2<pre>";print_r($qryb2);echo "</pre>"; }
					$rsltb2 = mysql_query($qryb2);
					$numb2 = mysql_num_rows($rsltb2);
					if($numb2>0){$iduri = mysql_result($rsltb2, 0, 'id');}
				}//end if
				
				
				//now add to cc_skosexactmatches
				if($iduri){
					
					//check for existing record
					
						
					$qryc = "UPDATE cc_entities SET asn_statementLabel='$iduri' WHERE identity = '$identity'";
					$rsltc = mysql_query($qryc);
					if( $rsltc ){ echo "&nbsp;&nbsp;&nbsp;SUCCESS: $qryc <br>"; }else{'did NOT update<br>';}
					
					
					
				}else{
					//soemthing went wrong!
					die("<h3>2. problem at process_asnstatementlabel</h3>");
				}//end if
				
			}//end foreach
		
		}//end if
		
		
		
		return true;
	
	
	}//end function
	
	
	//// functions returns an id
	public function get_id_literallanguage($etype, $literal, $language){
		
		$etype = mysql_real_escape_string($etype);
		$literal = mysql_real_escape_string($literal);
		$language = mysql_real_escape_string($language);
		
		//set up qrys now
		$qryb = "SELECT l.id FROM cc_literalslanguages l WHERE l.etype = '$etype' AND l.literal = '$literal' AND l.language = '$language' LIMIT 1";
		if( 1 ){ echo "<br>qryb<pre>";print_r($qryb);echo "</pre>"; }
		$rsltb = mysql_query($qryb);
		$numb = mysql_num_rows($rsltb);
		
		$id_literallanguage = null;
		if($numb > 0){
			//GET ID
			$id_literallanguage = mysql_result($rsltb, 0, 'id');
			
		}else{
			//ADD TO cc_literalslanguages
			$qryi = "INSERT INTO cc_literalslanguages VALUES (NULL, '$etype', '$literal', '$language')";
			$rslti = mysql_query($qryi);
			if(!$rslti){die("noooo! didnt insert new cc_literalslanguages/$etype");}
			
			//now go get id again
			$qryb2 = "SELECT u.id FROM cc_literalslanguages u WHERE u.etype = '$etype' AND u.literal = '$literal' AND u.language = '$language' LIMIT 1";
			if( 1 ){ echo "<br>qryb2<pre>";print_r($qryb2);echo "</pre>"; }
			$rsltb2 = mysql_query($qryb2);
			$numb2 = mysql_num_rows($rsltb2);
			if($numb2>0){$id_literallanguage = mysql_result($rsltb2, 0, 'id');}
		}//end if
		
		
		return $id_literallanguage;
		
	}//end function
	
	
	//// functions returns an id
	public function get_id_uripref($etype, $uri, $pref){
		
		$etype = mysql_real_escape_string($etype);
		$uri = mysql_real_escape_string($uri);
		$pref = mysql_real_escape_string($pref);
		
		//set up qrys now
		$qryb = "SELECT u.id FROM cc_uripreflabels u WHERE u.etype = '$etype' AND u.uri = '$uri' AND u.prefLabel = '$pref' LIMIT 1";
		if( 1 ){ echo "<br>qryb<pre>";print_r($qryb);echo "</pre>"; }
		$rsltb = mysql_query($qryb);
		$numb = mysql_num_rows($rsltb);
		
		$id_uripref = null;
		if($numb > 0){
			//GET ID
			$id_uripref = mysql_result($rsltb, 0, 'id');
			
		}else{
			//ADD TO cc_literalslanguages
			$qryi = "INSERT INTO cc_uripreflabels VALUES (NULL, '$etype', '$uri', '$pref')";
			$rslti = mysql_query($qryi);
			if(!$rslti){die("noooo! didnt insert new cc_uripreflabels/$etype");}
			
			//now go get id again
			$qryb2 = "SELECT u.id FROM cc_uripreflabels u WHERE u.etype = '$etype' AND u.uri = '$uri' AND u.prefLabel = '$pref' LIMIT 1";
			if( 1 ){ echo "<br>qryb2<pre>";print_r($qryb2);echo "</pre>"; }
			$rsltb2 = mysql_query($qryb2);
			$numb2 = mysql_num_rows($rsltb2);
			if($numb2>0){$id_uripref = mysql_result($rsltb2, 0, 'id');}
		}//end if
		
		
		return $id_uripref;
		
	}//end function
	
	
	
	//// functions returns _____
	//// function expects _____
	public function familyerator($thisentity, $idparent){
		
		
		if(isset($thisentity['children'])){
			$numchildrens = count($thisentity['children']);
			if($numchildrens > 0){
				echo "<div class='dbfield child'>children</div> : <div class='dbvalue'> ".$numchildrens."</div><br>";
				echo "<div class='children-wrapper'>";

					foreach($thisentity['children'] as $child){
						$idparent = $this->getidentityfromid($thisentity['id']);										
						//ADD TO DB!
						echo "<div class='child' style='margin-left:20px;'>";echo "<h4>child entity</h4>";
							$this->process_cc_children($child, $idparent);			
							
						echo "</div>";
						//get idparent
						$this->familyerator($child, $idparent);	
					}//end foreach
				echo "</div>";
				
			}//end if
			
		}//end if isset children	

	
	
	
	}//end function
	
	
	//// functions returns _____
	//// function expects _____
	public function process_cc_children($thisentity, $idparent){
		
		if( 0 ){ echo "<h4>cc_children start</h4>"; }

		//check for valid ELA or MATH components
		$component = $this->checkforcomponent();

		//get base vars
		$id = $thisentity['id'];
		$id = mysql_real_escape_string($id);
		$idchild = $this->getidentityfromid($id);	
		
		$component = mysql_real_escape_string($component);
		$idchild = mysql_real_escape_string($idchild);
		$idparent = mysql_real_escape_string($idparent);	
		
		
		if( 1 ){ echo "<h3>--- $id (idchild $idchild) has (idparent $idparent) ---</h3></h3>";}
		
		//do db action
		if( 1 ){ echo "<br>do db action<br>"; }
		//chk for existing
		if($this->chkforexisting_childparent($component, $idchild, $idparent)){
			//exists -- do nothing
		}else{
			//no exist, so add
			$qry = "INSERT INTO cc_children VALUES(NULL, '$component', $idparent, $idchild )";
			if( 1 ){ echo "<br>qry $qry<br>"; }
			$rslt = mysql_query($qry);
			
			if(!$rslt){die("noooo! didnt insert new cc_children for $idchild as child of $idparent");}
		
		}//end if
		
		return true;
		
	}//end function
	
	
	
	
	
	
	
	

}//end class
