<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    <title>jQuery UI Tabs - Default functionality</title>
    <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.6.custom.css">
    <script src="js/jquery-1.4.2.min.js"></script>
	<script src="js/jquery-ui-1.8.6.custom.min.js"></script>
	<script src="flot/jquery.flot.js"></script>
	<style>
		div {
		  font-family: sans-serif;
		  font-size: 15px;
		}
	</style>
    <script>
    var prefix = 'http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=';
    var ipArray =[
		"184.73.95.117",
		"75.101.232.42",
		"67.202.3.128",
		"50.16.20.176",
		"174.143.141.50"
    ];
    
    $(function() {
/*
		var d1 = [];
		for (var i = 0; i < 14; i += 0.5)
			d1.push([i, Math.sin(i)]);

		var d2 = [[0, 3], [4, 5], [8, 5]];
		var d20 = [[0, 3], [4, 8], [8, 5], [9, 18]];
		
		var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];
		var d30 = [[0, 8], [7, 12]];
		
//		$.plot($("#placeholder-1"), [ d1, d30 ]);
//		$.plot($("#placeholder-3"), [ d1, d2, d3 ]);
*/
		$.each(ipArray,function(index,value){
			var url = 'ip-'+index;
			$('<li><a href="#' + url + '">'+value+'</a></li>').appendTo($('#tab_ul'));
			var iframe = $('<iframe width="100%" height="600px" src="'+ prefix + value +'"></iframe>');
			var div = $('<div id="'+url+'"></div>');
			iframe.appendTo(div);
			//iframe.hide();
			div.appendTo($('#tabs')).append($('<div>aaaa</div>'));
			iframe.load(function() {
				console.log($(this).html());
			});			
		});
		
		$( "#tabs" ).tabs({
			select: function(event, ui) {
				//$(ui.panel).append('<iframe>a</iframe>');
				
				if (ui.index==3){
					//alert(ui.index);
					//$( "#tabs" ).tabs("load",3);
					//ui.panel.location.href = "http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161";
				}
			 }
		});
		
		//$( "#tabs" ).tabs( "http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",3,"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161");
		
    });
    </script>
</head>

<body>

<div id="tabs" style="width:50%">
    <ul id="tab_ul">
        <li><a href="#summary">Summary</a></li>		
    </ul>
    <div id="summary">
		<div id="placeholder-1"></div>
		 <h2>Summary</h2>
    </div>
	
	
</div>

</body>
