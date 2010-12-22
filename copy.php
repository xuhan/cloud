<?
//$command = "/usr/bin/sudo scp -i new.pem test.txt ec2-user@10.202.78.161:~";
//$command = "./exec";
//echo $command;

//echo posix_kill(21647, 30);

$myFile = "new_ip.txt";
@unlink($myFile);

$ourFileHandle = fopen($myFile, 'w') or die("can't open file");
fclose($ourFileHandle);

echo "Copied monitoring agent to the target server...";
include "menu.html";
?>
