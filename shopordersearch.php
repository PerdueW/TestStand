<?php 
    require('connection.php');
    connect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shop Order Number Search(Specific)</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript">
</script>

<script>
function focus() 
{
    document.getElementById("son").focus();
}
</script>

<script type="text/javascript">
    var regex="";
    var teststr="";
    function sontest()
    {	
        regex=/^([a-zA-Z]{1}\d{6}\s\d{1,3})$/;
        teststr=document.getElementById("son").value;
        if (regex.test(teststr))
        {
            sonsearchquery(teststr);
        }
        else
        {
            window.alert("Invalid Shop Order Number");
        }
    }
</script>

</head>
<body onload="focus()">
    <center><h1>Shop Order Number Search (Specific)</h1></center>    
    <nav id="nav01"></nav>
    <div id="main">            
        <form name="sonquery" id="sonquery" action="connection.php?sonQuery" method="post">                                  
            <label for="son">Shop Order Number:</label>
            <input type="text" size="22" name="son" id="son" value="" maxlength="20" placeholder="SON XXXXXXX XXX"></input>
            &nbsp;&nbsp;&nbsp;&nbsp;  
            <input type="button" value="submit" onclick="sontest()" /><br />
            <br />
            <div name="sontestresults" id="sonsearchquerydiv">  
                <table id="sonsearchquerytable">                    
                </table>
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
