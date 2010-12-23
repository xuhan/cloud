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
   	rowNum:30,
   	rowList:[30,40,50],
   	pager: '#pager10',
   	sortname: 'id',
	height: 380,	
    viewrecords: true,
    sortorder: "desc",
	multiselect: true,
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
$(function() {


		jQuery("#m1").click( function() {
		var s = jQuery("#list10").jqGrid('getGridParam','selarrrow');
		if (s.length > 0)	
		{
			var ret;
			var sum="";
			for (var i=0; i<s.length; i++){
				ret = jQuery("#list10").jqGrid('getRowData',s[i]);
				sum +=ret.privateipaddress+" ";
			}
			//alert(sum);
			document.stopinstance.location.href="agent_install.php?s="+sum;
		} else { 
			alert("Please select row");
		}
		});


});


$(function(){$("#list10").jqGrid('navGrid','#pager10',{add:false,edit:false,del:false});});
</script>
 
</head>


<table id="list10"></table>
<div id="pager10"></div>
<br />
<table id="list10_d"></table>
<div id="pager10_d"></div>
<!--a href="javascript:void(0)" id="ms1">Get Selected id's</a-->

<!--a href="javascript:void(0)" id="m1">Get Selected id's</a-->
<style>
input.groovybutton
{
   font-size:14px;
   font-weight:bold;
   width:220px;
   height:35px;
   background-color:#FF9933;
   border-style:solid;
   border-width:1px;
}
</style>
<iframe name=stopinstance frameborder=0 width=0 height=10></iframe>

<div>

<input id="m1"
   type="submit"
   name="groovybtn1"
   class="groovybutton"
   value="    Install Monitoring Agent"
   title="">

</div>





