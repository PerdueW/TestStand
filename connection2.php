<html>
<head>
<title> PHP Test Script </title>
</head>
<body>

<?php
	$conn = mysqli_connect('192.168.60.233', 'root', 'root', 'TestStandDB');
	// Check connection
	if (!$conn) 
	{
	    die("Connection failed: " . mysqli_connect_error());
	}
	// Start Test Code Section

	$models = "SELECT model FROM models";
	$modelsresult = mysqli_query($conn, $models);
	$modelcount = mysqli_num_rows($modelsresult);
	$x = 1;
	$mac = '00:D0:5F:02:3E:99';

	if (mysqli_num_rows($modelsresult) > 0) 
	{
	// output data of each row
	    while($row = mysqli_fetch_assoc($modelsresult)) 
	    {		
                $model = str_replace("-", "_", $row["model"]);
				$mystring.= "SELECT '".$model."' as tablename, mac, testdatetime, TestStand, TEST__status FROM m".$model." where mac='".$mac."'";
				if($x < $modelcount)
				{
					$mystring.= " UNION ";
					$x = $x + 1;
				}
				else
				{
					$mystring.= 'order by testdatetime';
				}			
	    }
	} 
	else 
	{
	echo "0 results";
	}
	$modelsresult = mysqli_query($conn, $mystring);
	if(! $modelsresult )
	{
  	    die('Could not retrieve data: ' . mysql_error());
	}
	else
	{
	    while($row = $modelsresult->fetch_array())
	    {
		echo $row['tablename'] . " " . $row['mac'] . " " . $row['testdatetime'] . " " . $row['TestStand'] . " " . $row['TEST__status'];
		echo "<br />";
	    }	
	}
	// End Test Code Section
	mysqli_close($conn); 	
?> 

</body>
</html> 
