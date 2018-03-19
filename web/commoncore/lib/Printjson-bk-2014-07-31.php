<?php
//get db action class
//include_once('lib/ParsetoDB.php');


class Printjson{
	
	
		
	//prints id, text and asn_identifier
	public function id_entifier_text($thisentity){
		if( !isset($thisentity['id']) ){echo "MAJOR ISSUE: NO id."; die();}
		//if( !isset($thisentity['asn_identifier']) ){echo "MAJOR ISSUE: NO asn_identifier."; die();}
		//if( !isset($thisentity['asn_identifier']) ){$thisentity['asn_identifier']=NULL;}
		$thisentity['asn_identifier'] = $thisentity['id'];
		if( !isset($thisentity['text']) ){echo "MAJOR ISSUE: NO text."; die();}
		
		echo "<div class='dbfield'>id</div> : <div class='dbvalue'> ".$thisentity['id']."</div><br>";
		echo "<div class='dbfield'>asn_identifier</div> : <div class='dbvalue'> ";print_r($thisentity['asn_identifier']);echo "</div><br>";
		echo "<div class='dbfield'>text</div> : <div class='dbvalue'> ".$thisentity['text']."</div><br>";
	
		return true;
	}//end function
	
	
	//prints local subject
	public function localsubject($thisentity){
		if(isset($thisentity['asn_localSubject'])){
			echo "<div class='dbfield'>asn_localSubject</div> : <div class='dbvalue'> ".$thisentity['asn_localSubject']."</div><br>";
		}//end if
	}//end function	
	
	
	////returns asn_authorityStatus, dcterms_language, asn_indexingStatus, dcterms_subject		
	function uriprefables($thisentity){
		if(isset($thisentity['asn_authorityStatus'])){
			echo "<div class='dbfield'>asn_authorityStatus</div> : <div class='dbvalue'> ";print_r($thisentity['asn_authorityStatus']);echo "</div><br>";
		}//end if
		if(isset($thisentity['dcterms_language'])){
			echo "<div class='dbfield'>dcterms_language</div> : <div class='dbvalue'> ";print_r($thisentity['dcterms_language']);echo "</div><br>";
		}//end if
		if(isset($thisentity['asn_indexingStatus'])){
			echo "<div class='dbfield'>asn_indexingStatus</div> : <div class='dbvalue'> ";print_r($thisentity['asn_indexingStatus']);echo "</div><br>";
		}//end if
		if(isset($thisentity['dcterms_subject'])){
			echo "<div class='dbfield'>dcterms_subject</div> : <div class='dbvalue'> ";print_r($thisentity['dcterms_subject']);echo "</div><br>";
		}//end if
	
	}//end function
	
	
	
	////returns dcterms_description, asn_statementLabel
	public function literalslanguages($thisentity){
		if(isset($thisentity['dcterms_description'])){
			echo "<div class='dbfield'>dcterms_description</div> : <div class='dbvalue'> ";print_r($thisentity['dcterms_description']);echo "</div><br>";
		}//end if
		if(isset($thisentity['asn_statementLabel'])){
			echo "<div class='dbfield'>asn_statementLabel</div> : <div class='dbvalue'> ";print_r($thisentity['asn_statementLabel']);echo "</div><br>";
		}//end if
		
	
	}//end function
	
	
	//// returns LEAF and sub-statements that appear only in a leaf
	public function leafable($thisentity){
		if(isset($thisentity['leaf'])){
				echo "<div class='dbfield leaf'>leaf</div> : <div class='dbvalue'> TRUE </div><br>";
				if(isset($thisentity['asn_statementNotation'])){
					echo "<div class='dbfield'>asn_localSubject</div> : <div class='dbvalue'> ".$thisentity['asn_statementNotation']."</div><br>";
				}//end if
				
				if(isset($thisentity['skos_exactMatch'])){
					echo "<div class='dbfield'>skos_exactMatch</div> : <div class='dbvalue'> ";print_r($thisentity['skos_exactMatch']);echo "</div><br>";
				}//end if
				
				
				if(isset($thisentity['asn_statementLabel'])){
					echo "<div class='dbfield'>asn_statementLabel</div> : <div class='dbvalue'> ";print_r($thisentity['asn_statementLabel']);echo "</div><br>";
				}//end if
				
				if(isset($thisentity['asn_altStatementNotation'])){
					echo "<div class='dbfield'>asn_altStatementNotation</div> : <div class='dbvalue'> ".$thisentity['asn_altStatementNotation']."</div><br>";
				}//end if			
				if(isset($thisentity['asn_listID'])){
					echo "<div class='dbfield'>asn_listID</div> : <div class='dbvalue'> ".$thisentity['asn_listID']."</div><br>";
				}//end if
				
		}//end if leaf
	}//end function
	
	
	
	////return cls
	public function clsornot($thisentity){
			if(isset($thisentity['cls'])){
				echo "<div class='dbfield'>cls</div> : <div class='dbvalue'> ".$thisentity['cls']."</div><br>";
			}else{
				echo "<div class='dbfield'>cls</div> : <div class='dbvalue'> </div><br>";	
			}//end if
	}//end function
	
	
	//// returns children entities (RECURSIVE)
	public function childerator($thisentity){
		
		$dbaction = new ParsetoDB();
		
		if(isset($thisentity['children'])){
			$numchildrens = count($thisentity['children']);
			if($numchildrens > 0){
				echo "<div class='dbfield child'>children</div> : <div class='dbvalue'> ".$numchildrens."</div><br>";
				echo "<div class='children-wrapper'>";
					foreach($thisentity['children'] as $child){
					
						//ADD TO DB!
						//$dbaction->addentity($child);
						if( 1 ){ echo "<h4>OFF: dbaction->addentity()</h4>"; }
						
						echo "<div class='child' style='margin-left:40px;'>";echo "<h4>child entity</h4>";
							$this->id_entifier_text($child);			
							$this->localsubject($child);
							$this->uriprefables($child);
							$this->literalslanguages($child);		
							$this->clsornot($child);					
							$this->leafable($child);
						echo "</div>";
						$this->childerator($child);	
					}//end foreach
				echo "</div>";
				
			}//end if
			
		}//end if isset children	
	
	}//end function
	
	
	
	//// function creates html of error/instructional msg
	public function print_q_error(){

	
	
	$this->print_doctype();
	$this->print_TOS();
	$this->print_creativecommonslicense();
	$this->print_head();
		
		
	//print opening info to provide context
	$this->print_preamble();
	
	//PRINT INFO ABT q.php API
	$this->print_query_API();

	//PRINT INFO ABT u.php API	
	$this->print_detail_API();
	
	//PRINT full example
	$this->print_fullexample_API();
	
	
	$this->print_closing();
		
	$this->print_footer();
	
	$this->print_endbodyendhtml();
	
		
	die();
	
	}//end function
	






//////////////PRINT_functions()
	
	//DOCTYPE 
	public function print_doctype(){
	
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
	echo "
	<html xmlns='http://www.w3.org/1999/xhtml'
	      xmlns:og='http://ogp.me/ns#'
	      xmlns:fb='https://www.facebook.com/2008/fbml'>
	";
	
	
	}//end function
	
	
	
	
	
	public function print_TOS(){
	
	echo "
	<!-- TERMS OF SERVICE -->
	<!-- The tools and API endpoints at http://standards.trails.by urls are provided AS-IS, with NO WARRANTY, no FORMAL support, and no promise of availability. Efforts were made to ensure the data is correct as the time of the version number, but the standards could change, or the source could have errors or been deprecated, etc. We made this for ourselves and are making it available to others in the hopes that you find it helpful. That said, if you have a comment, find an error or omission or just have an idea or word of thanks, feel free to contact mariochampion@trails.by. Good Luck! -->
	
	";
	
	
	}//end function
	
	
	// HEAD
	public function print_head(){
	
	echo "<head>";		
	
	$this->print_meta();
	$this->print_linkedfiles();
	
	echo "
	</head><body>
	";

	
	
	}//end function
	
	
	
	
	
	
	//CREATIVE COMMONS LICENSE
	public function print_creativecommonslicense(){
	
	echo "
	<!-- CREATIVE COMMONS LICENSE INFO-->
	<!-- The tools and API endpoints at http://standards.trails.by urls are made possible by Trails.by (http://trails.by), which re-worked the data made available under the Creative Commons Attribution license (http://creativecommons.org/licenses/by/3.0/us/) by The Achievement Standards Network (ASN) at http://www.achievementstandards.org/. 
	
	Accordingly, this work is distributed under the Creative Commons Attribution license (http://creativecommons.org/licenses/by/3.0/us/)
	
	Thanks open internetz!! 
	love,
	Trails.by Team		
	-->
	
	";
	
	
	}//end function


	

	
	// META TAGS
	public function print_meta(){
	
	echo "
	<title>Search Common Core Standards by API :: standards.trails.by</title>

	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta name='robots' content='follow, index'>
	<meta name='description' content='Trails.by offers a REST API to search the Common Core standards, by grade, keyword and component, with JSON results. Creative Commons Licensed.'>
	<meta name='keywords' content='common core, common, core, commoncore, standards, search, API, REST, JSON, trails, trails.by, '>
	<meta name='viewport' content='width=device-width,initial-scale=1'>
	<meta name='revisit-after' content='5 days' />
	<meta name='Rating ' content='General' />
	
	<!-- facebook meta -->
	<meta property='og:site_name' content='Trails.by'/>
	<meta property='og:type' content='company'/>
	<meta property='og:url' content='http://standards.trails.by' />
	<meta property='og:title' content='Search the Commoncore Standards via a REST API :: standards.trails.by'/>
	<meta property='og:description' content='Trails.by offers a REST API to search the Common Core standards, by grade, keyword and component, with JSON results. Creative Commons Licensed. Love, the Trails for Education team.'/>
	<meta property='og:image' content='http://trails.by/trails_logo_square_fb.png'/>
	<meta property='fb:admins' content='840490313' />
	<meta property='fb:app_id' content='228488773892503'/>
	
	
		";
	
	
	}//end function

	//LINKED FILES
	public function print_linkedfiles(){
	echo "
	<link rel='apple-touch-icon' href='//trails.by/touch-icon-iphone.png' />
	<link rel='apple-touch-icon' sizes='114x114' href='//trails.by/touch-icon-iphone-retina.png' />
	<link rel='stylesheet' type='text/css' href='//standards.trails.by/commoncore/lib/style.css'>
	<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
	";
	?>
	<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/styles/default.min.css'>
	<script src='//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/highlight.min.js'></script>
	<script>hljs.initHighlightingOnLoad();</script>
	
	<script type='text/javascript'>
	$(document).ready(function() {
	  var detail_json = '{"url_final":"S11434E2","valid":"true","standard":{"identity":"1312","component":"math","url_final":"S11434E2","id":"http:\/\/asn.jesandco.org\/resources\/S11434E2","asn_identitifier":"http:\/\/purl.org\/ASN\/resources\/S11434E2","text":"Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.","dcterms_description":[{"id":"1864","literal":"Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.","language":"en-US"}],"asn_authorityStatus":[{"id":"3393","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNAuthorityStatus\/Original","preflabel":"Original Statement"}],"dcterms_language":[{"id":"3390","uri":"http:\/\/id.loc.gov\/vocabulary\/iso639-2\/eng","preflabel":"English"}],"asn_indexingStatus":[{"id":"3394","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNIndexingStatus\/Yes","preflabel":"Yes"}],"dcterms_subject":[{"id":"3395","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNTopic\/math","preflabel":"Math"}],"cls":"","leaf":"1","asn_statementNotation":"CCSS.Math.Content.6.G.A.1","asn_statementLabel":[{"id":"811","literal":"Standard","language":"en-US"}],"asn_altStatementNotation":"6.G.1","asn_listID":"1.","asn_uri":"http:\/\/asn.jesandco.org\/resources\/S11434E2","dcterms_educationLevel":[{"id":"7","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNEducationLevel\/6","preflabel":"6"}],"skos_exactMatch":[{"id":"2492","uri":"http:\/\/corestandards.org\/Math\/Content\/6\/G\/A\/1","preflabel":"http:\/\/corestandards.org\/Math\/Content\/6\/G\/A\/1"},{"id":"2493","uri":"urn:guid:1F31DD363906484D9D2779A34FB59610","preflabel":"urn:guid:1F31DD363906484D9D2779A34FB59610"}],"asn_localSubject":[],"asn_comment":[],"children":[]}}';
	  
	  var detail_jsonString = JSON.stringify(detail_json, null, 4);
      $('#jsonCode').text(detail_jsonString);
	  
	  
	  
	});
	</script>
	
	<?php
	
	}//end function
	
	
	
	
	
	// PREAMBLE
	public function print_preamble(){
		echo "<div class='preamble'>
		<strong>Hello.
		<br><br>
		Trails.by offers a small suite of REST APIs to search the Common Core standards, by grade, keyword and component, with a JSON object result.<br>
		Use the Query API to search for summary information of matching standards.<br>
		Use the Detail API to get detailed information on one specific standard.
		
		</div>
		";
		
	
	
	}//end function
	

	
	

	
	
	//QUERY API
	public function print_query_API(){
	
	echo "<div class='api-wrapper' style='border-top:1px solid #ddd;'>";
	echo "<div class='api-head wrapperhead'>The Query API</div><br>";
	echo "Three parameters are allowed:'c', 'k', 'g', but only 'c' is required.</strong>
	<br>
	<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=6,7,8' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=6,7,8</a></p></div>
	";
	echo "<ul><li class='api-head'>Required:</li>";
	echo "<ul><li><strong>c = component.</strong></li>
	<ul>
	<li>Acceptable values are 'ela' (English & Language Arts) OR 'math'.</li></ul>
	";
	echo "<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/q.php?c=math' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math</a></p></div>";
	echo "</ul></ul>
	";
	echo "<ul><li  class='api-head'>Optional:</li>";
	echo "<ul><li><strong>k = keyword(s).</strong></li>
	<ul>
	<li>To find standards containing a certain term, set k='exampleterm'</li>
	</ul>
	<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/q.php?c=math&k=triangle' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math&k=triangle</a></p></div></li>		
	<ul>
	<li>Omit 'k' to see all standards, regardless of keywords.</li>
	</ul>
	<div class='api-sample'><p>Omitted Ex: <a href='http://standards.trails.by/commoncore/q.php?c=ela&g=7,8,9' target='newbie'>http://standards.trails.by/commoncore/q.php?c=ela&g=7,8,9</a></p></div></li>
	";
	echo "<li><strong>g = grade level.</strong></li>
	<ul>
	<li>Acceptable values are 'k,1,2,3,4,5,6,7,8,9,10,11,12'.</li>
	<li>To find standards, for example, in grades 8 OR 9 OR 10, set g='8,9,10'.</li>
	</ul>
	<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=8,9,10' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=8,9,10</a></p></div>
	
	<ul>
	<li>Omit 'g' to search all grades which contain a keyword (if keyword is provided).</li>
	</ul>
	<div class='api-sample'><p>Omitted Ex: <a href='http://standards.trails.by/commoncore/q.php?c=math&k=triangle' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math&k=triangle</a></p></div></li></ul></ul>

	";

	echo "<ul><li  class='api-head'>Formatting/testing:</li>";
	echo "<ul><li><strong>f = format as array for human readability (instead of JSON)</strong></li>
	<ul>
	<li>If during testing, you desire more human readability and do not want to use an <a href='http://bit.ly/1ihwL2v' target='lmgtfy'>online json viewer</a>, simply add '&amp;f'</li>
	<li>Omit 'f' for default format of JSON.</li>
	
	</ul>
	<div class='api-sample'><p>Alternate format ex: <a href='http://standards.trails.by/commoncore/q.php?c=math&k=triangle&f' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math&k=triangle&f</a></p></div></li>
	";
	echo "</ul></ul>
	<br><br>
	";
	echo "</div><!-- end q.php -->
	
	
	";
	
	}//end function
	
	
	//DETAIL API
	public function print_detail_API(){
		echo "<div class='api-wrapper'>";
		echo "<div class='api-head wrapperhead'>The Detail API</div><br>";
		echo "One parameter is allowed and required: 'u', where the value of 'u' comes from a Query API call, as the 'url_final' property in the JSON object result.";
		echo "<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/u.php?u=S114355A' target='newbie'>http://standards.trails.by/commoncore/u.php?u=S114355A</a></p></div>
	";
		echo "<ul><li  class='api-head'>Formatting/testing:</li>";
		echo "<ul><li><strong>f = format as array for human readability (instead of JSON)</strong></li>
		<ul>
		<li>If during testing, you desire more human readability and do not want to use an <a href='http://bit.ly/1ihwL2v' target='lmgtfy'>online json viewer</a>, simply add '&amp;f'</li>
		<li>Omit 'f' for default format of JSON.</li>
		
		</ul>
		<div class='api-sample'><p>Alternate format ex: <a href='http://standards.trails.by/commoncore/u.php?u=S114355A&f' target='newbie'>http://standards.trails.by/commoncore/u.php?u=S114355A&f</a></p></div></li>
		";
		echo "</ul></ul>
		<br><br>
		";

		
		
		echo "<br><br></div><!-- end detail by url API-->";
	
	}//end function
	
	
	
	// FULL EXAMPLE WITH JSON RESULTS	
	public function print_fullexample_API(){
		echo "<div class='api-wrapper'>
		";
		echo "<div class='api-head wrapperhead'>Full Example</div><br>
		";
		echo "<span class='api-head'>Case: Find standards for 6th grade math that involves triangles.</span><br><br>
		";
		echo "Query API call:<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=6' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=6</a></p></div>
		
";
		echo "Query API JSON result:<div class='api-sample'><p> Next, programmatically pull out the <span style='background-color:yellow'>'url_final'</span> property(s) for use with the Detail API.<br><br>";
		?>
		
		{"component":"math","keywords":"triangle","education levels":"6","standards":[{"identity":"1312",<span style='background-color:yellow'>"url_final":"S11434E2"</span>,"id":"http:\/\/asn.jesandco.org\/resources\/S11434E2","asn_identitifier":"http:\/\/purl.org\/ASN\/resources\/S11434E2","text":"Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.","asn_statementNotation":"CCSS.Math.Content.6.G.A.1","asn_altStatementNotation":"6.G.1","dcterms_educationLevel":"http:\/\/purl.org\/ASN\/scheme\/ASNEducationLevel\/6"},{"identity":"1315",<span style='background-color:yellow'>"url_final":"S11434E5"</span>,"id":"http:\/\/asn.jesandco.org\/resources\/S11434E5","asn_identitifier":"http:\/\/purl.org\/ASN\/resources\/S11434E5","text":"Represent three-dimensional figures using nets made up of rectangles and triangles, and use the nets to find the surface area of these figures. Apply these techniques in the context of solving real-world and mathematical problems.","asn_statementNotation":"CCSS.Math.Content.6.G.A.4","asn_altStatementNotation":"6.G.4","dcterms_educationLevel":"http:\/\/purl.org\/ASN\/scheme\/ASNEducationLevel\/6"}]}
		
		<?php
		echo "</p></div>";
		
		echo "Detail API: Get more specific detail on one of the standards, setting 'u' equal to the desired 'url_final' property from the Query API results.<br><br>";
		echo "<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/u.php?u=S11434E2' target='newbie'>http://standards.trails.by/commoncore/u.php?u=<span style='background-color:yellow'>S11434E2</span></a></p></div></li>";
		
		echo "
		Detail API JSON result<div class='api-sample'><p>";
		?>
		
		{"url_final":"S11434E2","valid":"true","standard":{"identity":"1312","component":"math","url_final":"S11434E2","id":"http:\/\/asn.jesandco.org\/resources\/S11434E2","asn_identitifier":"http:\/\/purl.org\/ASN\/resources\/S11434E2","text":"Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.","dcterms_description":[{"id":"1864","literal":"Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.","language":"en-US"}],"asn_authorityStatus":[{"id":"3393","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNAuthorityStatus\/Original","preflabel":"Original Statement"}],"dcterms_language":[{"id":"3390","uri":"http:\/\/id.loc.gov\/vocabulary\/iso639-2\/eng","preflabel":"English"}],"asn_indexingStatus":[{"id":"3394","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNIndexingStatus\/Yes","preflabel":"Yes"}],"dcterms_subject":[{"id":"3395","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNTopic\/math","preflabel":"Math"}],"cls":"","leaf":"1","asn_statementNotation":"CCSS.Math.Content.6.G.A.1","asn_statementLabel":[{"id":"811","literal":"Standard","language":"en-US"}],"asn_altStatementNotation":"6.G.1","asn_listID":"1.","asn_uri":"http:\/\/asn.jesandco.org\/resources\/S11434E2","dcterms_educationLevel":[{"id":"7","uri":"http:\/\/purl.org\/ASN\/scheme\/ASNEducationLevel\/6","preflabel":"6"}],"skos_exactMatch":[{"id":"2492","uri":"http:\/\/corestandards.org\/Math\/Content\/6\/G\/A\/1","preflabel":"http:\/\/corestandards.org\/Math\/Content\/6\/G\/A\/1"},{"id":"2493","uri":"urn:guid:1F31DD363906484D9D2779A34FB59610","preflabel":"urn:guid:1F31DD363906484D9D2779A34FB59610"}],"asn_localSubject":[],"asn_comment":[],"children":[]}}
		
		<?php			
		echo "</p></div>";
		
		
		echo "</div><!-- end full example -->";
	}//end function
	

	//CLOSING TEXT
	public function print_closing(){
	echo "<br><br><strong>love,<br>
	<a href='http://trails.by' target='Trails'>the Trails.by Education Team</a>
	</strong>
	";

	
	
	
	}//end function
	
	
	//VERSION NUMBER
	public function print_versionNumber(){
	
		echo "V.2014-04-01. 	";
	
	
	}//end function

	
	//FOOTER TEXT
	public function print_footer(){
		echo "<div class='footer'>";
		$this->print_versionNumber();
		echo "Terms of Service and <a href='http://creativecommons.org/licenses/by/3.0/us/' target='cclicense'>Creative Commons License</a> and attribution in the page source.<br></div>";
	
	}//end function
	
	
	// CLOSE BODY AND HTML
	public function print_endbodyendhtml(){
	
	echo "
	
	</body></html>
	
	";
	
	
	}//end function
	
	
	
	
	
	
	
	
	
	
	//// function expects html of error msg
	public function print_u_error(){
				$this->print_creativecommonslicense();
		echo "<html><head></head><body style='padding-left:20px;font-size:16px;padding:5px;font-family:Trebuchet MS;'>
		";
		
		echo "<strong>Hello.
		<br><br>
		This endpoint expect a URL_FINAL code, usually retrieved from an earlier call. </strong>
		<br>
		Example: <a href='http://standards.trails.by/commoncore/u.php?u=S114355A' target='newbie'>http://standards.trails.by/commoncore/u.php?u=S114355A</a>";

		die();
	}//end function
	
}//end class


