<?php
$in_number = $_POST['number']; // get the requested page
$zone = $_POST['zone']; // get the requested page
$imageId = $_POST['imageId']; // get the requested page
$name = $_POST['name']; // get the requested page
$security = $_POST['security']; // get the requested page
@$monitoring = $_POST['monitoring']; // get the requested page
$key = $_POST['key']; // get the requested page
if(!$in_number) $in_number = 1;
if(!$monitoring) $monitoring = 0;
//ec2
require_once './awsphp/sdk/sdk.class.php';
$ec2 = new AmazonEC2();
$response = $ec2->describe_instances();

$response = $ec2->run_instances($imageId, $in_number, $in_number, array(
    'InstanceType' => 't1.micro',
    'KeyName' => $key,
    'SecurityGroup' => $security,
    'Monitoring.Enabled' => $monitoring ,
    'Placement.AvailabilityZone' => $zone
));

$count = 0;
foreach ($response->body->instancesSet->item as $item)
{
	//{
	$ins_id[$count] = (string) $item->instanceId;
	//}
	$count++;
}

$akis = array();
//ec2 end
for ($i=0;$i<$count;$i++){
$response = $ec2->create_tags($ins_id[$i], array(
    array('Key' => 'Name', 'Value' => $name),
));
}
if ($response->isOK()){

	echo "<script>alert('The instance $ins_id[0] has been created.'); location.href='list.php';</script>";

}else {
	
	echo "<script>alert('Unknown error...');</script>";
}
?>
