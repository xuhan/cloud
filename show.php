<!--meta http-equiv="refresh" content="3"-->


<link rel="stylesheet" type="text/css" media="screen" href="./css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" href="./css/ui-lightness/jquery-ui-1.8.7.custom.css" />
<style>
html, body,table {
    margin: 0;
    padding: 0;
    font-size: 12px;
}
</style>
 <html><body>

<?
$ip = $_GET["ip"];
if ($ip) $host = $ip;
else $host = "no host..";
$port = 1025;
$str ="id=1234&query=all\r\n";

$fp = fsockopen($host,$port,$errno,$errstr,$timeout=30);
$d="";
?>
<table><tr><td width=300><table>
<?
echo "<tr><td>Private IP Address</td><td>".$host."</tr>\n";
if ($fp){
fwrite($fp, $str);
	echo "<h3>Basic Information</h3>";
$str="";
	while(!feof($fp)) {
		$str = fgets($fp,4096);
		$tmp = array();
		$tmp = explode("=",$str);
		if (!isset($tmp[1])) $tmp[1] ="";
		if (strncmp($tmp[0],"Tas",3)==0 && !isset($tasdone)){echo "<tr><td><br><b>Tasks</b></td></tr>";$tasdone=1;}
		if (strncmp($tmp[0],"Cpu",3)==0 && !isset($cpudone)){echo "<tr><td><br><b>CPU</b></td></tr>";$cpudone=1;}
		if (strncmp($tmp[0],"Mem",3)==0 && !isset($memdone)){echo "</table></td><td width=300 valign=top><table><tr><td><br><b>Memory</b></td></tr>";$memdone=1;}
		if (strncmp($tmp[0],"Net",3)==0 && !isset($netdone)){echo "<tr><td><br><b>Network</b></td></tr>";$netdone=1;}
		if (strncmp($tmp[0],"pro",3)==0 && !isset($prodone)){echo "<tr><td><br><b>Processes</b></td></tr>";$prodone=1;}
		if (strncmp($tmp[0],"get",3)==0 && !isset($getdone)){echo "</table></td><td valign=top><table><tr><td><br><b>Others</b></td></tr>";$getdone=1;}
		
		echo "<tr><td>".$tmp[0]."</td><td>$tmp[1]</td></tr>\n";	
	}
fclose($fp); 
} else {
	echo "error";
}

$d = str_replace("\n","<br>",$d);
//echo $d;

?>
</table></td></tr></table>
</body></html>
