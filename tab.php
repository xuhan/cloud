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
    $(function() {

		var d1 = [];
		for (var i = 0; i < 14; i += 0.5)
			d1.push([i, Math.sin(i)]);

		var d2 = [[0, 3], [4, 5], [8, 5]];
		var d20 = [[0, 3], [4, 8], [8, 5], [9, 18]];
		
		var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];
		var d30 = [[0, 8], [7, 12]];
		
		$.plot($("#placeholder-1"), [ d1, d30 ]);
		$.plot($("#placeholder-3"), [ d1, d2, d3 ]);
		$( "#tabs" ).tabs();
    });
    </script>
</head>

<body>
		
<div class="demo">

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">CPU Usage</a></li>
        <li><a href="#tabs-2">System</a></li>
        <li><a href="#tabs-3">Memory</a></li>
    </ul>
    <div id="tabs-1">
		<div id="placeholder-1" style="width:600px;height:300px;"></div>
		 <h2>CPU Usage</h2>
    </div>
	
    <div id="tabs-2">
        <h3>Handles: </h3>
		<h3>Threads: </h3>
		<h3>Processes:</h3>
		<h3>Up Time:</h3>
		<h3>Commit (MB): </h3>
		
    </div>
	
    <div id="tabs-3">
		<div id="placeholder-3" style="width:600px;height:300px;"></div>
    </div>
</div>