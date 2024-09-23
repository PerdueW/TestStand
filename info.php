<?php
	phpinfo();
	$conn = mysql_connect('192.168.60.55', 'root', 'root');
	if(!conn)
	{
		die('Could not connect: ' .mysql_error());
	}
	echo 'Connection Successful!';
?>

