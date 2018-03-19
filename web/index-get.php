<html>
    <head>
        <title>standards.trails.by - tests - Access To Common Core</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>

        <script type="text/javascript">
        
            var url = 'http://www.AccessToCommonCore.com/api/ela/5';
            //var url = 'http://www.AccessToCommonCore.com/api/standard/Math.8.EE.A.1';
            
            $(document).ready(function() {
                
                $.support.cors = true;
                
                $.ajax({
                    type: 'GET',
                    url: url,
                    accept: 'application/json',
                    dataType: 'json',
                    success: function(data) { makeCommonCoreList(data); },
                    error: function() { alert('standards get failed!'); }
                });
            });
		
            function makeCommonCoreList(response) {
                var commonCore = response.data.common_core.children;
                formatDisplayHeaders(response.data.common_core);
                var content = '';
               
                $.each(commonCore, function (j, domainORstrand) { 
                    content += formatDomainOrStrand(domainORstrand);
                    
                    if (domainORstrand.hasOwnProperty('children')) {
                        $.each(domainORstrand.children, function (k, cluster) { 
                            content += formatCluster(cluster);

                            if (cluster.hasOwnProperty('children')) {
                                content += formatBeginList();
                                $.each(cluster.children, function (l, standard) { 
                                    content += formatStandard(standard);

                                    if (standard.hasOwnProperty('children')) {
                                        content += formatBeginList();
                                        $.each(standard.children, function (m, standardDetail) { 
                                            content += formatStandardDetail(standardDetail)
                                        });
                                        content += formatEndList();
                                    }
                                });
                                content += formatEndList();
                            }
                        });
                    }
                });
                    
                $(content).appendTo("#list-of-standards");
            }
            
            function formatDomainOrStrand(domain) {
                return ('<h3>'+domain.standard+'</h3>');
            }
            
            function formatCluster(cluster) {
                return ('<h4>'+cluster.standard+'</h4>');
            }
            
            function formatStandard(standard) {
                return ('<li><a>'+ standard.standard_code+'</a> '+standard.standard+'</li>');
            }
            
            function formatStandardDetail(standardDetail) {
                return ('<li><a>'+ standardDetail.standard_code+'</a> '+standardDetail.standard+'</li>');
            }
            
            function formatBeginList() {
                return ('<ul>');
            }
            
            function formatEndList() {
                return ('</ul>');
            }
            
            function formatDisplayHeaders(firstStandard) {
                var content = '<h3>standard: '+url+'<p>' + firstStandard.standard + '</p><h3>';
                $(content).appendTo("#curriculum-grade-header");
            }
        </script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="span9">
                    <div class="page-header span9 offset1">
                        <div id="curriculum-grade-header"></div>
                    </div>
                    <div class="well span9 offset1">
                        <div id="list-of-standards"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
