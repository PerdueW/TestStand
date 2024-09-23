<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Individual MAC Search</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript">
</script>

<script>
function focus() 
{
    document.getElementById("msmac").focus();
}
</script>

<script type="text/javascript">
    var regex="";
    var teststr="";
    function mactest()
    {	
        regex=/^([0-9A-F]{2}[:-]?){5}([0-9A-F]{2})$/;
        teststr=document.getElementById("msmac").value;
	    teststr = teststr.toUpperCase(); 
        if (regex.test(teststr))
        {
            macsearchquery(teststr);
        }
        else
        {
            window.alert("Invalid MAC address");
        }
    }
</script>

</head>
<body onload="focus()">
    <center><h1>Individual MAC Search</h1></center>    
    <nav id="nav01"></nav>
    <div id="main">            
        <form name="thmquery" id="query" action="connection.php?thmdbQuery" method="post">                                  
            <label for="msmac">MAC:</label>
            <input type="text" size="25" name="msmac" id="msmac" value="" maxlength="17" placeholder="MAC XX:XX:XX:XX:XX:XX"></input>
            &nbsp;&nbsp;&nbsp;&nbsp;  
            <input type="button" value="submit" onclick="mactest()" /><br />
            <br />
	    <label class="queryrunninglabel" id="queryrunninglabel"><br /> Query running...... <br /></label>
	    <br /> 
            <div name="thmresults" id="macsearchquerydiv">  
                <table id="macsearchquerytable">                    
                </table>
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
