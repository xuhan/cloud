<?
$ip = $_GET["ip"];
if ($ip) $host = $ip;
else $host = "no host..";
$port = 1025;
$str ="test\r\n";

$fp = fsockopen($host,$port,$errno,$errstr,$timeout=30);
$d="";

if ($fp){
fwrite($fp, $str);
while(!feof($fp)) $d .= fgets($fp,4096); 
fclose($fp); 
} else {
	echo "error";
}

echo $host."<br>";
$d = str_replace("\n","<br>",$d);
echo $d;

?>
