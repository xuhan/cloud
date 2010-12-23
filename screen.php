<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Instances</title>
<!--link rel="stylesheet" type="text/css" media="screen" href="./css/custom-theme/jquery-ui-1.8.7.custom.css" /-->
<link rel="stylesheet" type="text/css" media="screen" href="./css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" href="./css/ui-lightness/jquery-ui-1.8.7.custom.css" />
<style>
html, body {
    margin: 0;
    padding: 0;
    font-size: 14px;
}


input.groovybutton
{
   font-size:14px;
   font-weight:bold;
   width:120px;
   height:40px;
   background-color:#FF9933;
   border-style:solid;
   border-width:1px;
}

</style>

</style>
<script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="./js/jquery-ui-1.8.7.custom.min.js" type="text/javascript"></script>
<script src="./js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="./js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(function() {
	//	$.each(ec2Array,function(index,value){
	//		var url = 'ec2-'+index;
	//		$('<li><a href="#' + url + '">Instance '+index+'</a></li>').appendTo($('#tab_ul'));
	//		$('<div id="'+url+'"><iframe width="958" frameborder=0 height="400px" src="'+ value +'"></iframe></div>').appendTo($('#tabs'));
	//
	//	});

		$( "#tabs" ).tabs({
			select: function(event, ui) {
				//$(ui.panel).append('<iframe>a</iframe>');

				if (ui.index==3){
					//alert(ui.index);
					//$( "#tabs" ).tabs("load",3);

				}
			 }
		});


var prefix="getpic.php";
var value = "?pic=r";
var inte = 10000;
$("#d1").load(prefix+value); 
var r1 = setInterval(function(){
 	$('#d1').load(prefix+value);}, inte);
$("#d2").load(prefix); 
var r2 = setInterval(function(){
 	$('#d2').load(prefix);}, inte);

$("#d3").load(prefix); 
var r3 = setInterval(function(){
 	$('#d3').load(prefix);}, inte);

$("#d4").load(prefix); 
var r4 = setInterval(function(){
 	$('#d4').load(prefix);}, inte);

});


</script>
</head>


<?

?>
<div class="demo">
<table width=1000><tr><td>
<div id="tabs">

    <ul id="tab_ul">
        <li><a href="#summary">EC2 Management</a></li>		
    </ul>
    <div id="summary">

		<div id="placeholder-1"></div>
		 <h2>Windows User Screen</h2>
	<table border=0>
		<tr height=280><td width=400><div id=d1></div> 
			50.16.108.253 (Windows)</td><td width=400><div id=d2></div>50.16.108.253 (Windows)</td></tr>
		<tr height=240><td width=400><div id=d3></div>50.16.108.253 (Windows)</td>
			<td width=400><div id=d4></div>50.16.108.253 (Windows)</td></tr>

	</table>

    </div>


</div></td></tr></table>


