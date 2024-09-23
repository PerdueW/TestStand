<?php  
	//echo "Hellos!";
	//echo "<br />";
	//echo "<br />";
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "TestStandDB";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn->connext_error)
	{
		die("Connection Failed!: " . $conn->connect_error);
	}

	$sql = "sselect column_name from information_schema.columns where column_name like '%Ring_On__Status' or '%Ring_Off__status'";
	$result = $conn->query($sql);
	$headers = $result->fetch_fields();
    foreach($headers as $header) 
    {
        $head[] = $header->name;
    }
    $fp = fopen('php://output', 'w');

    if ($fp && $result) 
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        fputcsv($fp, array_values($head)); 
        foreach($result as $line)
        {
            fputcsv($fp, $line);
        }
        fclose($fp);
        die;
    }
    echo $fp; 
    echo "<br />";
    echo $head;
    echo "<br />";
    $exportedActuals = json_encode($fp);
    echo $exportedActuals;
?>	


