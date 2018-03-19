<?php
					/*	cc_entities
						//-- fields
						identity
						component
						url_final
						id
						asn_identitifier
						text
						dcterms_description
						asn_authorityStatus
						dcterms_language
						asn_indexingStatus
						dcterms_subject
						cls
						leaf
						asn_statementNotation
						asn_statementLabel
						asn_altStatementNotation
						asn_listID
						*/	
						
						
						
/*
INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/K', 'K');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/1', '1');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/2', '2');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/3', '3');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/4', '4');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/5', '5');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/6', '6');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/7', '7');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/8', '8');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/9', '9');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/10', '10');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/11', '11');

INSERT INTO `standards`.`cc_uripreflabels` (`id`, `etype`, `uri`, `prefLabel`) VALUES (NULL, 'dcterms_educationLevel', 'http://purl.org/ASN/scheme/ASNEducationLevel/12', '12');
*/						

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
		
		if( $this->chkforexisting($thisentity) ){
			//dont add - already exists
			echo "<!-- dupe for". $thisentity['id']." -->";
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

			//DB ACTION
			$qry = "INSERT INTO cc_entities VALUES ('NULL', '$component','$urlfinal', '$id', '$asn_identitifier', '$text', '4', '5', '6', '7', '8', '$cls', '$leaf' ,'$asn_statementNotation', '12', '$asn_altStatementNotation', '$asn_listID' )";
			$rslt = mysql_query($qry);
			
			
			if($rslt){
				//true
			   	return true;
			}else{
				//false
			    //return false;
			    if( 1 ){ echo "<br><pre>INSERT INTO cc_entities VALUES ('NULL', '$component','$urlfinal', '$id', '$asn_identitifier', '$text', '4', '5', '6', '7', '8', '$cls', '$leaf' ,'$asn_statementNotation', '12', '$asn_altStatementNotation', '$asn_listID' ";die(); }die();
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
				$edu_label = $edulevel['prefLabel'];				

			}else{
				if( 0 ){ echo "<br>count NOT 2<br>"; }
				$keycount = count($key);
				if( 1 ){ echo "<br>count key = $key<br>"; }
				$edu_uri =  $entity_edulevels['uri'];
				$edu_label = $entity_edulevels['prefLabel'];				
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
					$edu_label = $edulevel['prefLabel'];				
	
				}else{
					if( 1 ){ echo "<br>count NOT 2<br>"; }
					$keycount = count($key);
					if( 1 ){ echo "<br>count key = $key<br>"; }
					$edu_uri =  $entity_skosmatches['uri'];
					$edu_label = $entity_skosmatches['prefLabel'];				
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
	public function process_asnlocalsubject($thisentity){
	
			return true;
	
	
	}//end function
	
	
	

	
	
	
	


}//end class
