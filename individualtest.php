<?php 
    //require('connection.php');
    //connect();
    $model = $_GET['model'];
    $mac = $_GET['mac'];
    $testdatetime = $_GET['testdatetime'];  
    $testname0 = $_GET['testname']; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Individual Tests </title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript">
</script>
</head>
<body>
    <center><h1>Individual Tests</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">            
            <label for="model">Model:</label>
            <select name="model" id="model" onchange="" style="width: 250px; text-align: center;">
                <option value = <?php echo $model; ?>><?php echo $model; ?></option>                                
            </select>                        
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="mac">MAC:</label>
            <select name="mac" id="mac" onchange="" style="width: 250px; text-align: center;">
                 <option value = <?php echo $mac; ?>><?php echo $mac; ?></option>                 
            </select>            
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="datetimestatus">Date and Time:</label>
            <select name="datetimestatus" id="datetimestatus" onchange="" style="width: 200px; text-align: center;">
                 <option value = <?php echo $testdatetime; ?>><?php echo $testdatetime; ?></option> 
            </select> 
	    <br /> <br />
	    &nbsp;&nbsp;&nbsp;&nbsp; 
	    <label for="" style="width:100px; display: inline-block; text-align: center; background-color: green"> Passed </label>
	    &nbsp;&nbsp;&nbsp;&nbsp; 
     	    <label for="" style="width:100px; display: inline-block; text-align: center; background-color: red">Failed</label> 
	    &nbsp;&nbsp;&nbsp;&nbsp; 
	    <label for="" style="width:100px; display: inline-block; text-align: center; background-color: yellow; color: black">Error</label>  
	    &nbsp;&nbsp;&nbsp;&nbsp; 
	    <label for="" style="width:100px; display: inline-block; text-align: center; background-color: white; color: black">Not Tested</label> 
            <br />  <br />
            <div name="individualtestdiv" id="individualtestdiv">  
            <table id="individualtestTBL"> 
            <?php
			$testnamex = str_replace("__status", "", $testname0);
			$smodel = str_replace("-", "_", $model); 
			$smodel = str_replace("m", "", $smodel); 
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = 'root';
			$dbname = 'TestStandDB';
			$conn  = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
			$query = "show columns FROM m".$smodel." where FIELD like '".$testnamex."%' and FIELD like '%__status'"; 
			$result  = $conn->query($query);     
			$result1 = $conn->query($query);  
			$Row = mysqli_fetch_assoc($result); 
			if ((mysqli_num_rows($result)=== 0) or (mysqli_num_rows($result)=== 1))
			{
				echo '<font color="white">There are currently no results for this test.</font>';
			}
			else
			{
				    $testing = array();
				    $first = 0;
				    while($value = mysqli_fetch_array($result))
				    { 	                      
					if (substr_count($value[0], '__') <= 3 && substr_count($value[0], '__') > 1)
					{   
					    $testing[] = $value[0];                           
					} 
				    }                
				    if(!$testing)
				    {
					$message = 'ERROR:'.mysqli_errno();
					return $message;
				    }
				    else
				    {                          
					$newcolumns = implode(",", $testing);  
					$qStr1 = "select ".$newcolumns." from m".$smodel." where mac='".$mac."' and testdatetime='".$testdatetime."'"; 
					$result2 = $conn->query($qStr1);                                               
					$ans = mysqli_fetch_array($result2);                  
					for ($i = 0; $i < count($testing); ++$i)
					{     
					    $testname = $testing[$i];
					    $status = $ans[$i];
					    $pass = stripos($status, "Pass");
					    $fail = stripos($status, "Fail"); 
					$error = stripos($status, "Error");                           
					    if($pass !== FALSE)
					    {
						$color = "#009933"; 
					    }
					    else if($fail !== FALSE)
					    {
						$color = "#CC0000";
					    }
					else if($error !== FALSE)
					    {
						$color = "#FFFF00";
					    }
					    else
					    {
						$color = "#ffffff"; 
					    }
					    $onclick = substr($testname, strrpos($testname, '__') + 0);  
					    if($onclick === "__status")
					    {
						$onclicks = "addCellHandlers3(this)";
					    }
					    else
					    {
						$onclicks = " ";
					    }
					    $testname1 = str_replace("__", " ", $testname); 
					    $testname2 = str_replace("_", " ", $testname1);
					    $testname3 = str_replace(" ", " ", $testname2);
					    $testname4 = str_replace("status", "", $testname3);
					    echo '<td onclick='.$onclicks.'><div style=" height:90px; width:200px; background-color:'.$color.'; word-wrap: break-word; color:#000000; border-left-style: solid; border-width: 2px;">'.$testname4.'<br /><br />'.$status.
						 '<input type="hidden" name="datetime" id="datetime" value="'.$testdatetime.'"/><input type="hidden" name="datetime" id="testname" value="'.$testname.'"/></td></div>';                            
					    if(($i+1) % 5 == 0)
					    {
						echo "</tr>\n";
						$cols = 0;
					    }                            
					}            
				    }
			}  
                ?>
                </table>
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
