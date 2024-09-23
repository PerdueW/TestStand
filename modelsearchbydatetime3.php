<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Model Search by Datetime</title>
<link href="site.css" rel="stylesheet">  </link>   
<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script> 
<script src="scripts.js"></script>
</head>
<body>
    <center><h1>Model Search by Datetime</h1></center>
    <nav id="nav01"></nav>    
    <div id="main"> 
        <form name="thmquery" id="query" action="" method="post">
            <label for="msdtmodel">Model:</label>
            <select name="msdtmodel" id="msdtmodel" onchange="" style="width: 75px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>                
            </select>                        
            &nbsp;            
            <label for="msdtstartdatetime">Start Date/Time:</label>
            <input type="text" name="msdtstartdate" id="msdtstartdate" class="tcal" onchange="" style="width: 150px; text-align: center; color:white;">
            &nbsp;
            <label for="msdtenddatetime">End Date/Time:</label>
            <input type="text" name="msdtenddatetime" id="msdtenddatetime" class="tcal" onchange="" style="width: 150px; text-align: center; color:white;">
        &nbsp;
            <input type="radio" name="macs" id="distinct" value="0"><font color="white"> Distinct </font>             
        <input type="radio" name="macs" id="all" value="1"><font color="white"> All </font>     
        &nbsp;&nbsp;
            <input type="button" value="submit" onclick="modeldatetimequery3()" />
            <br /><br />        
            <div name="dtmresults3" id="dtmresults3">  
                <table id="dtmresultstable3">                  
                </table>
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
