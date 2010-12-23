

<!--img src="http://50.16.108.253/screen.jpg?rand=<?=rand(1,1000);?>" width=300-->

<?

@$pic = $_GET['pic'];
if (isset($pic)){
	//echo "go";
	//@unlink("screen.jpg");
	$rand = rand(1,1000);
	system("wget --no-cache http://10.214.131.75/screen.jpg?rand=$rand -O screen.jpg" );
	copy("screen.jpg", "screen2.jpg");
	//sleep(1);
}
else {
	//echo "yes";
}
?>

<img src="screen2.jpg?rand=<?=rand(1,1000)?>" width=300>
