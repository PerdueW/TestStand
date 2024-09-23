<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Mac and Test Fails </title>
<link href="site.css" rel="stylesheet">  </link>   
<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script> 
<script src="scripts.js"></script>

<script type="text/javascript">
</script>

</head>
<body onload="focus()">
    <center><h1> Mac and Test Fails </h1></center>    
    <nav id="nav01"></nav>
    <div id="main">            
        <form name="thmquery" id="query" action="connection.php?thmdbQuery" method="post">                                  
            <label for="msdtmodel">Model:</label>
            <select name="msdtmodel" id="msdtmodel" onchange="" style="width: 250px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>                
            </select>                        
            &nbsp;            
            <label for="msdtstartdatetime">Start Date/Time:</label>
            <input type="text" name="msdtstartdate" id="msdtstartdate" class="tcal" onchange="" style="width: 250px; text-align: center; color:white;">
            &nbsp;
            <label for="msdtenddatetime">End Date/Time:</label>
            <input type="text" name="msdtenddatetime" id="msdtenddatetime" class="tcal" onchange="" style="width: 250px; text-align: center; color:white;">
            &nbsp;
            <input type="radio" name="macs" id="distinct" value="0"><font color="white"> Distinct </font>             
            <input type="radio" name="macs" id="all" value="1"><font color="white"> All </font>          
            <input type="button" value="submit" onclick="mactestfails()" /><br />
            <br />
		    <label class="queryrunninglabel" id="queryrunninglabel"><br /> Query running...... <br /></label>
		    <br /> 
            <div name="mactestfailsresults" id="mactestfailsresults">  
                <table id="mactestfailsresultstable">                    
                </table>
            </div>            
        </form> 
        <br /><br />
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>