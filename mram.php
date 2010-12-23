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

});

$(function(){$("#list10").jqGrid('navGrid','#pager10',{add:false,edit:false,del:false});});


</script>
</head>


<?

require_once './awsphp/sdk/sdk.class.php';
$ec2 = new AmazonEC2();
$response = $ec2->describe_instances();
$akis = array();
$count = 0;
$ip = array();
$name = array();
$cpu = array();
foreach ($response->body->reservationSet->item as $item)
{
	//{
	@$name[$count] = (string) $item->instancesSet->item->tagSet->item[0]->value;
	@$ip[$count] = (string) $item->instancesSet->item->privateIpAddress;
	//}
	$port = 1025;
	$str ="id=1234&query=all\r\n";
	$fp = @fsockopen($ip[$count],$port,$errno,$errstr,$timeout=30);
	if ($fp){
	fwrite($fp, $str);
	$str="";
	while(!feof($fp)) {
		$str = fgets($fp,4096);
		$tmp = array();
		$tmp = explode("=",$str);
		if (!isset($tmp[1])) $tmp[1] ="";
		if (strncmp($tmp[0],"Memory total",12)==0){
			$cpu[$count] = $tmp[1];
			$cpu[$count] = str_replace("k", " ", $cpu[$count]);
			break;
		}
		
	}
	fclose($fp); 
	}
	$count++;
}

/*$response = $ec2->describe_images(array(
    'Owner' => 'amazon'
));
$count = 0;
print_r($response);
foreach ($response->body->imageSet->item as $item)
{
	
}*/
?>
<div class="demo">
<table width=1000><tr><td>
<div id="tabs">

    <ul id="tab_ul">
        <li><a href="#summary">EC2 Management</a></li>		
    </ul>
    <div id="summary">

		<div id="placeholder-1"></div>
		 <h2>Memory</h2>
	<table>
	<? for ($i=0;$i < count($ip);$i++) { ?>
		<tr><td> <b>[<?=$ip[$i]?>]</b> <?=$name[$i]?></td><td>

		<? 
			$cpu_p = 0;
			$cpu_b = 0;
			if (isset($cpu[$i])){
				$cpu_p = $cpu[$i];
				$cpu_b = $cpu_p /3000;
			}
			echo "<table border=0><tr><td bgcolor='ff0000' width='$cpu_b'></td><td>$cpu_p k</td></tr></table>";
		?>
			</td></tr>
	<? } ?>


	</table>

    </div>


</div></td></tr></table>


