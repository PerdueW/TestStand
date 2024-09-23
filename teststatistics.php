<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Statistics</title>
<link href="site.css" rel="stylesheet">  </link>   
<script  src="scripts.js" type="text/javascript">
</script>
</head>
<body onload="modelstatistics(); distinctmodelstatistics();" > 
    <center><h1>Test Statistics</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">            
        <form name="teststatsquery" id="teststatsquery" action="connection.php?teststats" method="post">	    
	    <div class="floatLeft">
	    <font size="3" color="white">All Model Test Results</font> 
	    <br />
	    <label class="queryrunninglabel" id="queryrunninglabel"><br /> Query running...... <br /></label>
	    <br />  
            <table name="modelstatisticsSectiontable" id="modelstatisticsSectiontable">                    
            </table>
	    </div>
	    <div class="floatRight">
    <font size="3" color="white">Distinct Model Test Results</font><font size="2" color="grey"> Results may skew due to overlapping test results </font>
	    <br /> 
	    <label class="queryrunninglabel1" id="queryrunninglabel1"><br /> Query running...... <br /></label>
	    <br />  
            <table name="distinctmodelstatisticsSectiontable" id="distinctmodelstatisticsSectiontable">                    
            </table>
	    </div>
	    <br /><br />
	    <div>	
            <label for="model">Model:</label>
            <select name="tsmodel" id="tsmodel" onchange="OnSelectChange(this)" style="width: 250px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>                
            </select>                        
            &nbsp;&nbsp;&nbsp;&nbsp;              
            <input type="button" value="submit" onclick="teststats()" /> 
	    </div>   
	    <br />
	    <label class="queryrunninglabel2" id="queryrunninglabel2"><br /> Query running...... <br /></label>
	    <br />    
            <div name="teststatsresults" id="teststatsresults">  
            <table name="teststatsresultsSection" id="teststatsresultsSection">                    
            </table>             
            </div>         
        </form>        
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
</body>
</html>

