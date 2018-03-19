<?php
	
	//get some files
	include_once('lib/security.php');
	include_once('lib/ParsetoDB.php');
	include_once('lib/Printjson.php');
	
	//get prepared to print soem data for debugging
	$printjson = new Printjson();
	$dbaction = new ParsetoDB();
?>	
	
<html>
<head>
</head>
<body style="font-size:10px;padding:5px;font-family:Trebuchet MS;">	
	
	
<?	
	//// --- get some data
	$component = $_SERVER['QUERY_STRING'];//get which component we are parsing
		if(trim($component) == "" ){$component='math';}
		if($component != "math" && $component != "ela"){die("whoa -- weird component:$component");}

	$qry = "SELECT e.* FROM cc_entities e WHERE e.component='$component'";
	$rslt = mysql_query($qry);
	
	
	$entities_fields = array('identity','component','url_final','id','asn_identitifier', 'text','dcterms_description','asn_authorityStatus','dcterms_language','asn_indexingStatus','dcterms_subject','cls','leaf','asn_statementNotation','asn_statementLabel','asn_altStatementNotation','asn_listID');
	
	
	if(!$rslt){
		die("NO RESULT from $qry ");
	}else{
		
		if(mysql_num_rows($rslt) > 0): ?>
		<table style='font-size:10px;padding:5px;font-family:Trebuchet MS;'>
			<tr>
		    <?php while($row = mysql_fetch_assoc($rslt)): 
		    	
		    	foreach( $entities_fields as $entities_field){
		    		echo "<th style='background-color:#efefef'>$entities_field</th>
		    	";
		    	}//end foreach
		    		
		    ?>
			</tr>
		    <tr style="background-color:#ddd;border:3px solid #fff;">

				<?php
				foreach( $entities_fields as $entities_field){
					 echo "<td> ".$row[$entities_field]." </td>
					 "; 
				}//end foreach	 
				?>
					
				
		    </tr>
		    <?php endwhile; ?>
		</table>
		<?php endif; ?>
		
<?php		
	}//end if
?>






	
