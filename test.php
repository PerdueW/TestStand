<? php
	require('connection.php');
    connect();

    $alldata = "";
    $sql = "show columns FROM mESP_32_PS from TestStandDB WHERE Field like '%_actual'";
    $result = mysqli_query($GLOBALS['conn '],$sql); 
    while($data = $result->fetch_assoc())
    {
    	$alldata .= $data['son'] . ',' . $data['mac'] . "\n";

    	$response = 'data:text/csv; charset=utf-8, SON, MAC\n';
    	$response .= $alldata;
    	echo $response;
    }
?>