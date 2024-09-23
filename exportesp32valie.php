<?php  
	//echo "Hellos!";
	//echo "<br />";
	//echo "<br />";
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "TestStandDB";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn->connect_error)
	{
		die("Connection Failed!: ");
	}
    $colsql = "select column_name from information_schema.columns where table_name='mSA_VIP855' and column_name like '%actual'";
    $colresult = $conn->query($colsql);
    $columnnames = "";
    while($row = mysqli_fetch_array($colresult))
    {
        $columnnames .= $row[0].",";       
    }
    $columnnames = rtrim($columnnames, ",");
    $sql = "select mac, testdatetime," .$columnnames. " from mSA_VIP855 where testdatetime between '2020-08-01 00:00:01' and '2020-08-30 23:59:59'"; 
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


