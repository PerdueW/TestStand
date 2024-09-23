<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> ESP32 Test Results </title>
<link href="site.css" rel="stylesheet">  </link> 

<script>
</script>

<script>
function focus() 
{
    document.getElementById("msmac").focus();
}
</script>

<script type="text/javascript">
</script>

</head>
<body onload="focus()">
    <center><h1> ESP32 Test Results </h1></center>    
    <nav id="nav01"></nav>
    <div id="main">            
        <form name="thmquery" id="query" action="connection.php?thmdbQuery" method="post">                                  
            <label for="msdtmodel">Model:</label>
            <select name="msdtmodel" id="msdtmodel" onchange="" style="width: 250px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>       
            </select>                       
            &nbsp;&nbsp;&nbsp;&nbsp;  
            <input type="button" value="submit" onclick="esp32actuals()" /><br />
            <br />
		    <label class="queryrunninglabel" id="queryrunninglabel"><br /> Query running...... <br /></label>
		    <br /> 
            <div name="modelresults" id="modelresults">  
                <table id="modelresultstable">                    
                </table>
            </div> 
            <br />
            <div name="actualsResulttable" id="actualResulttable">  
	            <table id="actualsResulttable">                    
	            </table>
            </div>           
        </form> 
        <br /><br />
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
