<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test History by MAC</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript">
function hidemodel() 
{
	document.getElementById("label").style.visibility = "hidden";
}
</script>
</head>
<body>
    <center><h1>Test History by MAC</h1></center>    
    <nav id="nav01"></nav>
    <div id="main">            
        <form name="thmquery" id="query" action="connection.php?thmdbQuery" method="post">
            <label for="thmmodel">Model:</label>
            <select name="thmmodel" id="thmmodel" onchange="thmmodelSelectChange(this)" style="width: 250px; text-align: center;">
                <option value="">--Select--</option>
                <?php modelQuery(); ?>                
            </select>                        
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="thmmac">MAC:</label>
            <select name="thmmac" id="thmmac" onchange="thmmacSelectChange(this)" style="width: 250px; text-align: center;">
                 <option value="">--Select--</option>
            </select>              
            &nbsp;&nbsp;&nbsp;&nbsp;  
            <input type="button" value="submit" onclick="thmqueryDB()" /><br />
            <br />
	    <label class="queryrunninglabel" id="queryrunninglabel"><br /> Query running...... <br /></label>
	    <br />  
            <div name="thmresults" id="thmresults">  
                <table id="thmTABLEresults">                    
                </table>
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
