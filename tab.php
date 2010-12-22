<html lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    <title>jQuery UI Tabs - Default functionality</title>

    <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.7.custom.css">

    <script src="js/jquery-1.4.2.min.js"></script>

	<script src="js/jquery-ui-1.8.7.custom.min.js"></script>
	<script src="flot/jquery.flot.js"></script>

	<style>
		div {
		  font-family: sans-serif;

		  font-size: 15px;
		}

	</style>
    <script>
    var ec2Array =[

		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",

		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",

		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",

		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",

		"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161"

    ];
    
    $(function() {

/*
		var d1 = [];
		for (var i = 0; i < 14; i += 0.5)

			d1.push([i, Math.sin(i)]);

		var d2 = [[0, 3], [4, 5], [8, 5]];

		var d20 = [[0, 3], [4, 8], [8, 5], [9, 18]];
		
		var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];

		var d30 = [[0, 8], [7, 12]];
		
//		$.plot($("#placeholder-1"), [ d1, d30 ]);

//		$.plot($("#placeholder-3"), [ d1, d2, d3 ]);
*/
		$.each(ec2Array,function(index,value){

			var url = 'ec2-'+index;

			$('<li><a href="#' + url + '">Instance '+index+'</a></li>').appendTo($('#tab_ul'));

			$('<div id="'+url+'"><iframe width="100%" height="600px" src="'+ value +'"></iframe></div>').appendTo($('#tabs'));

		});

		$( "#tabs" ).tabs({

			select: function(event, ui) {

				//$(ui.panel).append('<iframe>a</iframe>');

				if (ui.index==3){

					//alert(ui.index);
					//$( "#tabs" ).tabs("load",3);

					//ui.panel.location.href = "http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161";

				}
			 }
		});


		//$( "#tabs" ).tabs( "http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161",3,"http://ec2-50-16-20-176.compute-1.amazonaws.com/show.php?ip=10.202.78.161");


    });
    </script>
</head>


<body>

<div class="demo">


<div id="tabs">

    <ul id="tab_ul">
        <li><a href="#summary">EC2 Summary</a></li>		

    </ul>
    <div id="summary">

		<div id="placeholder-1"></div>
		 <h2>EC2 Summary</h2>

    </div>


</div>

