<?

require_once './awsphp/sdk/sdk.class.php';
$ec2 = new AmazonEC2();

$instances =  $_GET['s'];
$inst = explode(" ", $instances);

$count = 0;
for ($i=0;$inst[$i];$i++){
	$response = $ec2->start_instances($inst);
}
echo "<script>alert('$instances has been started');parent.location.href=parent.location.href;</script>";

?>
