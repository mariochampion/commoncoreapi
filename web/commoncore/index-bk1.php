<?php
include_once('../security.php');



//prints id, text and asn_identifier
function print_id_entifier_text($thisentity){

	echo "<div class='dbfield'>id</div> : <div class='dbvalue'> ".$thisentity['id']."</div><br>";
	echo "<div class='dbfield'>asn_identifier</div> : <div class='dbvalue'> ".$thisentity['asn_identifier']."</div><br>";
	echo "<div class='dbfield'>text</div> : <div class='dbvalue'> ".$thisentity['text']."</div><br>";


}//end function


//prints local subject
function print_localsubject($thisentity){
	if($child['asn_localSubject']){
		echo "<div class='dbfield'>asn_localSubject</div> : <div class='dbvalue'> ".$thisentity['asn_localSubject']."</div><br>";
	}//end if
}//end function	


////returns asn_authorityStatus, dcterms_language, asn_indexingStatus, dcterms_subject		
function print_uriprefables($thisentity){
	if($thisentity['asn_authorityStatus']){
		echo "<div class='dbfield'>asn_authorityStatus</div> : <div class='dbvalue'> ".$thisentity['asn_authorityStatus']."</div><br>";
	}//end if
	if($thisentity['dcterms_language']){
		echo "<div class='dbfield'>dcterms_language</div> : <div class='dbvalue'> ".$thisentity['dcterms_language']."</div><br>";
	}//end if
	if($thisentity['asn_indexingStatus']){
		echo "<div class='dbfield'>asn_indexingStatus</div> : <div class='dbvalue'> ".$thisentity['asn_indexingStatus']."</div><br>";
	}//end if
	if($thisentity['dcterms_subject']){
		echo "<div class='dbfield'>dcterms_subject</div> : <div class='dbvalue'> ".$thisentity['dcterms_subject']."</div><br>";
	}//end if

}//end function



////returns dcterms_description, asn_statementLabel
function print_literalslanguages($thisentity){
	if($thisentity['dcterms_description']){
		echo "<div class='dbfield'>dcterms_description</div> : <div class='dbvalue'> ".$thisentity['dcterms_description']."</div><br>";
	}//end if
	if($thisentity['asn_statementLabel']){
		echo "<div class='dbfield'>asn_statementLabel</div> : <div class='dbvalue'> ".$thisentity['asn_statementLabel']."</div><br>";
	}//end if
	

}//end function


//// returns LEAF and sub-statements that appear only in a leaf
function print_leafable($thisentity){
	if($thisentity['leaf']){
			echo "<div class='dbfield leaf'>leaf</div> : <div class='dbvalue'> TRUE </div><br>";
			if($thisentity['asn_statementNotation']){
				echo "<div class='dbfield'>asn_localSubject</div> : <div class='dbvalue'> ".$thisentity['asn_statementNotation']."</div><br>";
			}//end if
			
			if($thisentity['skos_exactMatch']){
				echo "<div class='dbfield'>skos_exactMatch</div> : <div class='dbvalue'> ".$thisentity['skos_exactMatch']."</div><br>";
			}//end if
			
			
			if($thisentity['asn_statementLabel']){
				echo "<div class='dbfield'>asn_statementLabel</div> : <div class='dbvalue'> ".$thisentity['asn_statementLabel']."</div><br>";
			}//end if
			
			if($thisentity['asn_altStatementNotation']){
				echo "<div class='dbfield'>asn_altStatementNotation</div> : <div class='dbvalue'> ".$thisentity['asn_altStatementNotation']."</div><br>";
			}//end if			
			if($thisentity['asn_listID']){
				echo "<div class='dbfield'>asn_listID</div> : <div class='dbvalue'> ".$thisentity['asn_listID']."</div><br>";
			}//end if
			
	}//end if leaf
}//end function



////return cls
function print_clsornot($thisentity){
		if($thisentity['cls']){
			echo "<div class='dbfield'>cls</div> : <div class='dbvalue'> ".$thisentity['cls']."</div><br>";
		}else{
			echo "<div class='dbfield'>cls</div> : <div class='dbvalue'> </div><br>";	
		}//end if
}//end function





//// returns children entities (RECURSIVE)
function childerator($thisentity){
	if(isset($thisentity['children'])){
		$numchildrens = count($thisentity['children']);
		if($numchildrens > 0){
			echo "<div class='dbfield child'>childrenz</div> : <div class='dbvalue'> ".$numchildrens."</div><br>";
			echo "<div class='children-wrapper'>";
				foreach($thisentity['children'] as $child){
					echo "<div class='child' style='margin-left:40px;'>";echo "<h4>child entity</h4>";
						print_id_entifier_text($child);			
						print_localsubject($child);
						print_uriprefables($child);
						print_literalslanguages($child);		
						print_clsornot($child);					
						print_leafable($child);
					echo "</div>";
					childerator($child);	
				}//end foreach
			echo "</div>";
			
		}//end if
		
	}//end if isset children	

}//end function


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
	$json = file_get_contents("./commoncore-json/commoncore-math-D10003FC.json");
	$json_array = json_decode($json, TRUE);
	$identity = 0;

	//START MASTER FOREACH
	foreach( $json_array as $key=>$entity){
		echo "<h3>--- entity ".$identity++."--</h3>";
		
		// id, asn_identifier,text
		print_id_entifier_text($entity);
		
		// dcterms_description, asn_statementLabel
		print_literalslanguages($entity);
		
		// asn_authorityStatus, dcterms_language, asn_indexingStatus, dcterms_subject		
		print_uriprefables($entity);
		
		// localsubject
		print_localsubject($entity);
		
		// cls
		print_clsornot($entity);
		
		// childrens
		childerator($entity);
		
		
		
	}//end MASTER foreach
	
	
	
	
	
	
	?>
	</body>
<html>       