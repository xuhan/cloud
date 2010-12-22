<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Amazon EC2 Instances</title>
 
<!--link rel="stylesheet" type="text/css" media="screen" href="./css/custom-theme/jquery-ui-1.8.7.custom.css" /-->
<link rel="stylesheet" type="text/css" media="screen" href="./css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" href="./css/ui-lightness/jquery-ui-1.8.7.custom.css" />
<style>
html, body {
    margin: 0;
    padding: 0;
    font-size: 80%;
}
</style>
 
<script src="./js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="./js/jquery-ui-1.8.7.custom.min.js" type="text/javascript"></script>
<script src="./js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="./js/jquery.jqGrid.min.js" type="text/javascript"></script>
 
<script type="text/javascript">

$(function(){
	$("#list10").jqGrid({
   	url: "list_get.php?q=2&rows=15",
	datatype: "json",
   	colNames:['No', 'Name', 'Instance ID', 'Image ID','State', 'Key', 'Instance Type', 'Domain', 'Launch Time', 'Zone', 'IP Address', 'Private IP Addr', 'Architecture'],
   	colModel:[
   		{name:'id',index:'id', width:20},
   		{name:'name',index:'name', width:110},
   		{name:'instanceId',index:'instanceId', width:75},
   		{name:'imageId',index:'imageId', width:85},
   		{name:'state',index:'state', width:70},
   		{name:'key',index:'key', width:45},
   		{name:'instancetype',index:'instancetype', width:85},
   		{name:'domain',index:'domain', width:125},
   		{name:'launch',index:'launch', width:85},
   		{name:'zone',index:'zone', width:85},
   		{name:'ipddress',index:'ipaddress', width:95},
   		{name:'privateipaddress',index:'privateipaddress', width:85},
   		{name:'architecture',index:'architecture', width:30},
   	],
   	rowNum:15,
   	rowList:[15,30,45],
   	pager: '#pager10',
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
	multiselect: false,
	caption: "Amazon EC2 Instances",
	onSelectRow: function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#list10_d").jqGrid('getGridParam','records') >0 )
			{
				jQuery("#list10_d").jqGrid('setGridParam',{url:"subgrid.php?q=1&id="+ids,page:1});
				jQuery("#list10_d").jqGrid('setCaption',"Invoice Detail: "+ids)
				.trigger('reloadGrid');
			}
		} else {
			jQuery("#list10_d").jqGrid('setGridParam',{url:"subgrid.php?q=1&id="+ids,page:1});
			jQuery("#list10_d").jqGrid('setCaption',"Invoice Detail: "+ids)
			.trigger('reloadGrid');			
		}
	}
 });
});

var prefix = 'http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=';
var ipArray =[
	"184.73.95.117",
	"75.101.232.42",
	"67.202.3.128",
	"50.16.20.176",
	"174.143.141.50"
];
$(function() {
		$.each(ipArray,function(index,value){
			var url = 'ip-'+index;
			$('<li><a href="#' + url + '">'+value+'</a></li>').appendTo($('#tab_ul'));
			var iframe = $('<iframe width="100%" height="600px" src="'+ prefix + value +'"></iframe>');
			var div = $('<div id="'+url+'"></div>');
			iframe.appendTo(div);
			iframe.hide();
			div.appendTo($('#tabs'));
			iframe.load(function() {
				//alert('good');
				//console.log( $(this).contents().find('body').eq(0).html());
				var arr = $(this).contents().find('body').eq(0).html().split('<br>');
				$.each(arr,function(i,value){
					div.append('<div>' + value + '</div>');
				});
			});			
		});
		$( "#tabs" ).tabs({
			select: function(event, ui) {

				//ui.panel.chidren('iframe').attr('src',$(ui.panel).chidren('iframe').attr('src'));
				//$(ui.panel).append('<iframe>a</iframe>');
				
				if (ui.index==3){
					//alert(ui.index);
					//$( "#tabs" ).tabs("load",3);
					//ui.panel.location.href = "http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161";
				}
			 }
		});
});

$(function(){$("#list10").jqGrid('navGrid','#pager10',{add:false,edit:false,del:false});});


</script>
 
</head>


<table id="list10" height=100%></table>
<div id="pager10"></div>
<br />
<table id="list10_d"></table>
<div id="pager10_d"></div>
<!--a href="javascript:void(0)" id="ms1">Get Selected id's</a-->

<table width=1000><tr><td>
<div id="tabs">

    <ul id="tab_ul">
        <li><a href="#summary">Instance Monitoring Information</a></li>		
    </ul>
    <div id="summary">

		<div id="placeholder-1"></div>
		 <h2>Summary</h2>

    </div>


</div></td></tr></table>


