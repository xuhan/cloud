<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./css/ui-lightness/jquery-ui-1.8.7.custom.css" />
<style>
html, body {
    margin: 0;
    padding: 0;
    font-size: 90%;
}
</style>
 


<script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="./js/jquery-ui-1.8.7.custom.min.js" type="text/javascript"></script>
<script src="./js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="./js/jquery.jqGrid.min.js" type="text/javascript"></script>
 
<script type="text/javascript">
	$(function() {
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		var autoHeight = false;
		$("#accordion").accordion({
			icons: icons,
			autoHeight: false
		});
		$( "#toggle" ).button().toggle(function() {
			$( "#accordion" ).accordion( "option", "icons", false );
		}, function() {
			$( "#accordion" ).accordion( "option", "icons", icons );
		});
	});
</script>
</head>
<body>
<div class="demo">

<div id="accordion">
	<h3><a href="#">EC2 Management</a></h3>
	<div>
	<ul>
	<li><a href='list.php' target='content'>Instances</a></li>
	<li><a href='create.php' target='content'>Create Instance</a></li>
	<li><a href='agent.php' target='content'>Install Agent</a></li>
	<li><a href='stop.php' target='content'>Stop Instance</a></li>
	<li><a href='start.php' target='content'>Start Instance</a></li>
	<li><a href='terminate.php' target='content'>Terminate Instance</a></li>
	</ul>
	</div>
	<h3><a href="#">Monitoring</a></h3>
	<div>
	<ul>
	<li><a href='mcpu.php' target='content'>CPU Usage</a></li>
	<li><a href='mram.php' target='content'>RAM</a></li>
	<li><a href='mnet.php' target='content'>Network</a></li>
	<!--li><a href='terminate.php' target='content'>Process</a></li-->
	</ul>
	</div>
	
	<h3><a href="#">Monitoring (History)</a></h3>
	<div>
	<ul>
	<li><a href='list.php' target='content'>CPU Usage</a></li>
	<li><a href='create.php' target='content'>RAM</a></li>
	<li><a href='stop.php' target='content'>Network</a></li>
	<li><a href='terminate.php' target='content'>Process</a></li>
	</ul>
	</div>


	<h3><a href="#">Screen</a></h3>
	<div><ul>
	<li><a href='screen.php' target='content'>Screen Monitoring</a></li>
	</ul>
	</div>
</div>

</div><!-- End demo -->



<table>
</table>

</body>
</html>
