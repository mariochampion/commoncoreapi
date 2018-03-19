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
	</head>
	
	<body>
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
	
	<!-- standard meta -->
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
	<!-- linked files -->
	<link rel='apple-touch-icon' href='//trails.by/touch-icon-iphone.png' />
	<link rel='apple-touch-icon' sizes='114x114' href='//trails.by/touch-icon-iphone-retina.png' />
	<link rel='stylesheet' type='text/css' href='//standards.trails.by/commoncore/lib/style.css'>
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Inconsolata'>
	";
	
	}//end function
	
	
	
	
	
	// PREAMBLE
	public function print_preamble(){
	
	echo "<div class='api-head wrapperhead'>Common Core Search API Overview</div><br>
	";
	echo "<div class='preamble'>
	<strong>Hello.<br>
	Trails.by offers two REST APIs to search the Common Core standards by <span style='background-color:yellow'>grade and/or keyword and/or component</span>, with a JSON object result.
	<br>
	<ol>
	<li>Use the <a href='#queryapi-info'>Query API</a> to search for summary information of matching standards.</li>
	
	<li>Use the <a href='#detailapi-info'>Detail API</a> to get detailed information on one specific standard.</li>
	
	<li>Check out the <a href='#fullexample-info'>Full Example</a> of a query call, result, detail call and detail result.</li>
	</ol>
	</div>
	
	";
	
	}//end function
	

	
	

	
	
	//QUERY API
	public function print_query_API(){
	echo "<!-- COMMON CORE STANDARDS QUERY API -->
	";
	echo "<a name='queryapi-info'></a>
	";
	echo "<div class='api-wrapper' style='border-top:1px solid #ddd;'>
	";
	echo "<div class='api-head wrapperhead'>The Query API</div><br>
	";
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
	echo "<!-- COMMON CORE STANDARDS DETAIL API -->
	";
	echo "<a name='detailapi-info'></a>
	";
	echo "<div class='api-wrapper'>
	";
	echo "<div class='api-head wrapperhead'>The Detail API</div><br>"
	;
	echo "One parameter is allowed and required: 'u', where the value of 'u' comes from a Query API call, as the 'url_final' property in the JSON object result.
	";
	echo "<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/u.php?u=S114355A' target='newbie'>http://standards.trails.by/commoncore/u.php?u=S114355A</a></p></div>
";
	echo "<ul><li  class='api-head'>Formatting/testing:</li>
	";
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
	echo "<br><br></div><!-- end detail by url API-->
	
	";
	
	}//end function
	
	
	
	// FULL EXAMPLE WITH JSON RESULTS	
	public function print_fullexample_API(){
	echo "<!-- COMMON CORE STANDARDS QUERY AND DETAIL FULL EXAMPLE -->
	";
	echo "<a name='fullexample-info'></a>
	";
	echo "<div class='api-wrapper'>
	";
	echo "<div class='api-head wrapperhead'>Full Example</div><br>
	";
	echo "<span class='api-head'>Case: Find standards for 6th grade math that involves triangles.</span><br><br>
	";
	echo "1. Query API call:<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=6' target='newbie'>http://standards.trails.by/commoncore/q.php?c=math&k=triangle&g=6</a></p></div>
	
";
	echo "2. Query API JSON result (with <span style='background-color:yellow'>'url_final'</span> property highlighted) :<div class='api-sample'>";
	?>
<pre>		
{
  &quot;component&quot;: &quot;math&quot;,
  &quot;keywords&quot;: &quot;triangle&quot;,
  &quot;education levels&quot;: &quot;6&quot;,
  &quot;standards&quot;: [
    {
      &quot;identity&quot;: &quot;1312&quot;,
      <span style='background-color:yellow'>&quot;url_final&quot;: &quot;S11434E2&quot;</span>,
      &quot;id&quot;: &quot;http:\/\/asn.jesandco.org\/resources\/S11434E2&quot;,
      &quot;asn_identitifier&quot;: &quot;http:\/\/purl.org\/ASN\/resources\/S11434E2&quot;,
      &quot;text&quot;: &quot;Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.&quot;,
      &quot;asn_statementNotation&quot;: &quot;CCSS.Math.Content.6.G.A.1&quot;,
      &quot;asn_altStatementNotation&quot;: &quot;6.G.1&quot;,
      &quot;dcterms_educationLevel&quot;: &quot;http:\/\/purl.org\/ASN\/scheme\/ASNEducationLevel\/6&quot;
    },
    {
      &quot;identity&quot;: &quot;1315&quot;,
     <span style='background-color:yellow'> &quot;url_final&quot;: &quot;S11434E5&quot;</span>,
      &quot;id&quot;: &quot;http:\/\/asn.jesandco.org\/resources\/S11434E5&quot;,
      &quot;asn_identitifier&quot;: &quot;http:\/\/purl.org\/ASN\/resources\/S11434E5&quot;,
      &quot;text&quot;: &quot;Represent three-dimensional figures using nets made up of rectangles and triangles, and use the nets to find the surface area of these figures. Apply these techniques in the context of solving real-world and mathematical problems.&quot;,
      &quot;asn_statementNotation&quot;: &quot;CCSS.Math.Content.6.G.A.4&quot;,
      &quot;asn_altStatementNotation&quot;: &quot;6.G.4&quot;,
      &quot;dcterms_educationLevel&quot;: &quot;http:\/\/purl.org\/ASN\/scheme\/ASNEducationLevel\/6&quot;
    }
  ]
}
</pre>		
		<?php
		echo "</div>";
		
		echo "3. Detail API: Get more specific detail on one of the standards, setting 'u' equal to the desired 'url_final' property from the Query API results.<br><br>";
		echo "<div class='api-sample'><p>Ex: <a href='http://standards.trails.by/commoncore/u.php?u=S11434E2' target='newbie'>http://standards.trails.by/commoncore/u.php?u=<span style='background-color:yellow'>S11434E2</span></a></p></div></li>";
		
		echo "
		4. Detail API JSON result<div class='api-sample'>";
		?>
<pre>		
{
  &quot;url_final&quot;: &quot;S11434E2&quot;,
  &quot;valid&quot;: &quot;true&quot;,
  &quot;standard&quot;: {
    &quot;identity&quot;: &quot;1312&quot;,
    &quot;component&quot;: &quot;math&quot;,
    &quot;url_final&quot;: &quot;S11434E2&quot;,
    &quot;id&quot;: &quot;http:\/\/asn.jesandco.org\/resources\/S11434E2&quot;,
    &quot;asn_identitifier&quot;: &quot;http:\/\/purl.org\/ASN\/resources\/S11434E2&quot;,
    &quot;text&quot;: &quot;Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.&quot;,
    &quot;dcterms_description&quot;: [
      {
        &quot;id&quot;: &quot;1864&quot;,
        &quot;literal&quot;: &quot;Find the area of right triangles, other triangles, special quadrilaterals, and polygons by composing into rectangles or decomposing into triangles and other shapes; apply these techniques in the context of solving real-world and mathematical problems.&quot;,
        &quot;language&quot;: &quot;en-US&quot;
      }
    ],
    &quot;asn_authorityStatus&quot;: [
      {
        &quot;id&quot;: &quot;3393&quot;,
        &quot;uri&quot;: &quot;http:\/\/purl.org\/ASN\/scheme\/ASNAuthorityStatus\/Original&quot;,
        &quot;preflabel&quot;: &quot;Original Statement&quot;
      }
    ],
    &quot;dcterms_language&quot;: [
      {
        &quot;id&quot;: &quot;3390&quot;,
        &quot;uri&quot;: &quot;http:\/\/id.loc.gov\/vocabulary\/iso639-2\/eng&quot;,
        &quot;preflabel&quot;: &quot;English&quot;
      }
    ],
    &quot;asn_indexingStatus&quot;: [
      {
        &quot;id&quot;: &quot;3394&quot;,
        &quot;uri&quot;: &quot;http:\/\/purl.org\/ASN\/scheme\/ASNIndexingStatus\/Yes&quot;,
        &quot;preflabel&quot;: &quot;Yes&quot;
      }
    ],
    &quot;dcterms_subject&quot;: [
      {
        &quot;id&quot;: &quot;3395&quot;,
        &quot;uri&quot;: &quot;http:\/\/purl.org\/ASN\/scheme\/ASNTopic\/math&quot;,
        &quot;preflabel&quot;: &quot;Math&quot;
      }
    ],
    &quot;cls&quot;: &quot;&quot;,
    &quot;leaf&quot;: &quot;1&quot;,
    &quot;asn_statementNotation&quot;: &quot;CCSS.Math.Content.6.G.A.1&quot;,
    &quot;asn_statementLabel&quot;: [
      {
        &quot;id&quot;: &quot;811&quot;,
        &quot;literal&quot;: &quot;Standard&quot;,
        &quot;language&quot;: &quot;en-US&quot;
      }
    ],
    &quot;asn_altStatementNotation&quot;: &quot;6.G.1&quot;,
    &quot;asn_listID&quot;: &quot;1.&quot;,
    &quot;asn_uri&quot;: &quot;http:\/\/asn.jesandco.org\/resources\/S11434E2&quot;,
    &quot;dcterms_educationLevel&quot;: [
      {
        &quot;id&quot;: &quot;7&quot;,
        &quot;uri&quot;: &quot;http:\/\/purl.org\/ASN\/scheme\/ASNEducationLevel\/6&quot;,
        &quot;preflabel&quot;: &quot;6&quot;
      }
    ],
    &quot;skos_exactMatch&quot;: [
      {
        &quot;id&quot;: &quot;2492&quot;,
        &quot;uri&quot;: &quot;http:\/\/corestandards.org\/Math\/Content\/6\/G\/A\/1&quot;,
        &quot;preflabel&quot;: &quot;http:\/\/corestandards.org\/Math\/Content\/6\/G\/A\/1&quot;
      },
      {
        &quot;id&quot;: &quot;2493&quot;,
        &quot;uri&quot;: &quot;urn:guid:1F31DD363906484D9D2779A34FB59610&quot;,
        &quot;preflabel&quot;: &quot;urn:guid:1F31DD363906484D9D2779A34FB59610&quot;
      }
    ],
    &quot;asn_localSubject&quot;: [
      
    ],
    &quot;asn_comment&quot;: [
      
    ],
    &quot;children&quot;: [
      
    ]
  }
}	
</pre>		
	<?php			
	echo "</div>
	";
	
	
	echo "</div><!-- end full example -->
	
	";
	}//end function
	

	//CLOSING TEXT
	public function print_closing(){
	echo "<br><br><strong>love,<br>
	<a href='http://trails.by' target='trails'>the Trails for Education Team</a>
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
		echo "Terms of Service and <a href='http://creativecommons.org/licenses/by/3.0/us/' target='cclicense'>Creative Commons License</a> and attribution in the page source.<br></div>
		
		";
	
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


