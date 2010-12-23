<?

require_once './awsphp/sdk/sdk.class.php';
$ec2 = new AmazonEC2();

$instances =  $_GET['s'];
$inst = explode(" ", $instances);

$count = 0;
for ($i=0;$inst[$i];$i++){
	$myFile = "new_ip.txt";
	@unlink($myFile);

	$ourFileHandle = fopen($myFile, 'w') or die("can't open file");
	fwrite($ourFileHandle, $inst[$i]."\n");
	fclose($ourFileHandle);

	//$response = $ec2->stop_instances($inst);
}
echo "<script>alert('Monitoring Agent has been installed to $instances');parent.location.href=parent.location.href;</script>";

?>
