<?php
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
@$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
@$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;
// connect to the database
////$db = mysql_connect($dbhost, $dbuser, $dbpassword)
////or die("Connection Error: " . mysql_error());

////mysql_select_db($database) or die("Error conecting to db.");
////$result = mysql_query("SELECT COUNT(*) AS count FROM invheader a, clients b WHERE a.client_id=b.client_id");
////$row = mysql_fetch_array($result,MYSQL_ASSOC);
////$count = $row['count'];


//ec2
require_once './awsphp/sdk/sdk.class.php';
$ec2 = new AmazonEC2();
$response = $ec2->describe_instances();
$akis = array();
$count = 0;
foreach ($response->body->reservationSet->item as $item)
{
	//{
	@$row[$count]['name'] = (string) $item->instancesSet->item->tagSet->item[0]->value;
	$row[$count]['instanceId'] = (string) $item->instancesSet->item->instanceId;
	$row[$count]['imageId'] = (string) $item->instancesSet->item->imageId;
	$row[$count]['state'] = (string) $item->instancesSet->item->instanceState->name;
	$row[$count]['key'] = (string) $item->instancesSet->item->keyName;
	$row[$count]['instancetype'] = (string) $item->instancesSet->item->instanceType;
	$row[$count]['domain'] = (string) $item->instancesSet->item->dnsName;
	$row[$count]['launch'] = (string) $item->instancesSet->item->launchTime;
	$row[$count]['zone'] = (string) $item->instancesSet->item->placement->availabilityZone;
	$row[$count]['ipaddress'] = (string) $item->instancesSet->item->ipAddress;
	$row[$count]['privateipaddress'] = (string) $item->instancesSet->item->privateIpAddress;
	$row[$count]['architecture'] = (string) $item->instancesSet->item->architecture;
	//}
	$count++;
}
//ec2 end

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
//$SQL = "SELECT a.id, a.invdate, b.name, a.amount,a.tax,a.total,a.note FROM invheader a, clients b WHERE a.client_id=b.client_id ORDER BY $sidx $sord LIMIT $start , $limit";
//$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
@$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=$start;
while(isset($row[$i])) {
    $responce->rows[$i]['id']=$i;
    $responce->rows[$i]['cell']=array($i,$row[$i]['name'],$row[$i]['instanceId'], $row[$i]['imageId']
			, $row[$i]['state'], $row[$i]['key'],  $row[$i]['instancetype'], $row[$i]['domain'], $row[$i]['launch'], $row[$i]['zone'],
 $row[$i]['ipaddress'], $row[$i]['privateipaddress'], $row[$i]['architecture'],
	);
    $i++;
}        
echo json_encode($responce);

?>
