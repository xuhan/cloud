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

    var ec2Array =[
		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",
		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",
		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",
		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",
		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161"

    ] ;
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
$response = $ec2->describe_availability_zones();
$count=0;
$zone = array();
foreach ($response->body->availabilityZoneInfo->item as $item)
{
	$zone[$count] = $item->zoneName;
	$count++;
}

$response = $ec2->describe_key_pairs();
$count=0;
$key = array();
foreach ($response->body->keySet->item as $item)
{
	$key[$count] = $item->keyName;
	$count++;
}

$response = $ec2->describe_security_groups();
$count=0;
$security = array();
foreach ($response->body->securityGroupInfo->item as $item)
{
	$security[$count] = $item->groupName;
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
		 <h2>Create Instance</h2>
	<table>
<form name=create action="create_instance.php" method=post>
	<tr><td>Number of Instances: </td><td><input type=text name='number' value=1></td></tr>
	<tr><td>Availability Zone: </td><td>
		<select type=text name='zone'>
			<? for ($i=0;$zone[$i];$i++){
				?> 
			<option value='<?=$zone[$i]?>'><?=$zone[$i]?></option>
				<?
				}
			?>
		</select>
	</td></tr>
	<tr><td>Image Type: </td><td>
		<select type=text name='imageId'>
			<option value='ami-08728661'>Basic 32-bit Amazon Linux AMI 1.0</option>
			<option value='ami-2272864b'>Basic 64-bit Amazon Linux AMI 1.0</option>
			<option value='ami-e0a35789'>SUSE Linux Enterprise Server 11 32-bit</option>
			<option value='ami-e4a3578d'>SUSE Linux Enterprise Server 11 64-bit</option>
			<option value='ami-c5e40dac'>Getting Started on Microsoft Windows Server 2008</option>
			<option value='ami-c3e40daa'>Basic Microsoft Windows Server 2008</option>
			<option value='ami-d9e40db0'>Basic 64-bit Microsoft Windows Server 2008</option>
			<option value='ami-dde40db4'>Microsoft SQLServer 2008 on Windows Server 2008</option>
			<option value='ami-aa30c7c3'>Cluster Instances HVM CentOS 5.5</option>
			<option value='ami-7ea24a17'>Basic Cluster Instances HVM CentOS 5.4</option>
		</select></td></tr>

	<tr><td>Monitoring</td><td><input type=checkbox name=monitoring>Enable</td></tr>
	<tr><td>Name</td><td><input type=text name=name value="test"></td></tr>
	<tr><td>Key</td><td>
		<select type=text name='key'>
			<? for ($i=0;$key[$i];$i++){
				?> 
			<option value='<?=$key[$i]?>'><?=$key[$i]?></option>
				<?
				}
			?>

		</select>
	</td></tr>
	<tr><td>Security Groups</td><td>
		<select type=text name='security'>
			<? for ($i=0;$security[$i];$i++){
				?> 
			<option value='<?=$security[$i]?>' <? if ($security[$i]=="quick-start-2") echo "selected"?> ><?=$security[$i]?></option>
				<?
				}
			?>
		
		</select>
	</td></tr>
	<tr><td></td><td>
	
<input
   type="submit"
   name="groovybtn1"
   class="groovybutton"
   value="Create"
   title="">
</td></tr>
</form>
	</table>

    </div>


</div></td></tr></table>


