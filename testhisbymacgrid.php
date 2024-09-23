<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test History by MAC (Grid)</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript"></script>
</head>
<body>
    <center><h1>Test History by MAC (Grid)</h1></center>
    <nav id="nav01"></nav>    
    <div id="main"> 
        <form name="thmquery" id="query" action="connection.php?thmdbQuery" method="post">
            <label for="model">Model:</label>
            <select name="model" id="model" onchange="OnSelectChange(this)" style="width: 75px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>                
            </select>                        
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="mac">MAC:</label>
            <select name="mac" id="mac" onchange="statusSelectChange(this)" style="width: 150px; text-align: center;">
                 <option value="" disabled selected>--Select--</option>
                 <?php macQuery(); ?>
            </select>            
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="datetimestatus">Date/Time/Status:</label>
            <select name="datetimestatus" id="datetimestatus" onchange="" style="width: 200px; text-align: center;">
                 <option value="" disabled selected>--Select--</option> 
            </select>            
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="submit" onclick="testbymacgrid()" /><br />
            <br />           
            <div name="thmgresults" id="thmgresults">  
                <table id="thmgtestresults" >                                                 
                </table>
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
</body>
</html>

