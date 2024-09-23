<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Model Statistics</title>
<link href="site.css" rel="stylesheet">  </link>  
</head>
<body onload="modelstatistics()">
    <center><h1>Model Statistics</h1></center>   
    <nav id="nav01"></nav>    
    <div id="main">
	<br /><br />  
        <table name="modelstatisticsSectiontable" id="modelstatisticsSectiontable">                    
        </table>
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
</body>
</html>

