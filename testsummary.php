<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Summary</title>
<link href="site.css" rel="stylesheet">  </link>   
<script  src="scripts.js" type="text/javascript">
</script>
</head>
<body onload="modelstatistics(); distinctmodelstatistics()"> 
    <center><h1>Test Summary</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">            
        <form name="testsummaryquery" id="testsummaryquery" action="connection.php?testsummary" method="post">
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
            <label for="model">Model:</label>
            <select name="tsummodel" id="tsummodel" onchange="OnSelectChange(this)" style="width: 250px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>                
            </select>  
	    &nbsp;&nbsp;&nbsp;&nbsp;
	    <input type="button" value="submit" onclick="testsummary()" /><br />
	    <br />
	    <label class="queryrunninglabel2" id="queryrunninglabel2"><br /> Query running...... <br /></label>
	    <br />                  	                 
            <div name="testssumresults" id="testssumresults">  
            <table name="testssumresultsSection" id="testssumresultsSection">                    
            </table>             
            </div>            
        </form>        
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
</body>
</html>

