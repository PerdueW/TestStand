<?php 
    require('connection.php');
    connect(); 
    $model = $_GET['model'];
    $mac = $_GET['mac'];
    $testdatetime = $_GET['datetimestatus'];
    $tableName = $_GET['tableName']; 
    $titletableName = str_replace('_', ' ', $tableName);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titletableName; ?> Results</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript"></script> 
<script type="text/javascript" src="canvasjs.min.js"></script> 
</head>
<body>
    <center><h1> <?php echo $titletableName; ?> Table Results</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">  
		<label for="model">Model:</label>
        <select name="model" id="model" onchange="OnSelectChange(this)" style="width: 250px; text-align: center;">
            <option value = <?php echo $model; ?>><?php echo $model; ?></option>                                
        </select>                        
        &nbsp;&nbsp;&nbsp;&nbsp;            
        <label for="mac">MAC:</label>
        <select name="mac" id="mac" onchange="statusSelectChange(this)" style="width: 250px; text-align: center;">
             <option value = <?php echo $mac; ?>><?php echo $mac; ?></option>                 
        </select>            
        &nbsp;&nbsp;&nbsp;&nbsp;            
        <label for="testdatetime">Date and Time:</label>
        <select name="testdatetime" id="testdatetime" onchange="" style="width: 250px; text-align: center;">
             <option value = <?php echo $testdatetime; ?>><?php echo $testdatetime; ?></option> 
        </select> 
        &nbsp;&nbsp;&nbsp;&nbsp;            
        <label for="testsuite">Test Suite:</label>
        <select name="testsuite" id="testsuite" onchange="" style="width: 250px; text-align: center;">
             <option value = <?php echo $titletableName; ?>><?php echo $titletableName; ?></option> 
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
        <br /> <br />         
    	<div name="individualtabletestdiv" id="individualtabletestdiv">  
        <table id="individualtabletestTBL"> 
        <?php 
        	$dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = 'root';
            $dbname = 'TestStandDB';
            $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        	$smodel1 = str_replace(' ', '', $model);
        	$smodel1 = str_replace('-', '_', $model);
        	$smodel1 = trim($smodel1);
			$query = "show columns FROM m".$smodel1."__".$tableName." where FIELD like '%__status' and FIELD not like 'Shop%'";
			$result  = $conn->query($query);     
			$row = mysqli_fetch_assoc($result); 
			if ((mysqli_num_rows($result)=== 0) or (mysqli_num_rows($result)=== 1))
			{
				echo '<font color="white">There are currently no results for this test.</font>';
			}
			else
			{
				$testing = [];
			    $first = 0;
			    while($value = mysqli_fetch_array($result))
			    {
					if (substr_count($value[0], '__') <= 3 && substr_count($value[0], '__') >= 1)
					{  
					    array_push($testing,$value[0]);                       
					} 
			    } 
			    echo "<br />";
			    if(empty($testing))
			    { 
    				echo "Array is empty! Please verify you have data in table"; 
					//echo "Query: ". $query ."<br >"; 
    			}
    			else
    			{
    				$newcolumns = implode(",", $testing);  
					$qStr1 = "select ".$newcolumns." FROM m".$smodel1."__".$tableName." where mac='".$mac."' and testdatetime='".$testdatetime."'"; 
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
							$onclicks = "addCellHandlersSpecTests(this)";
					    }
					    else
					    {
							$onclicks = " ";
					    }
					    $testname1 = str_replace("__", " ", $testname); 
					    $testname2 = str_replace("_", " ", $testname1);
					    $testname3 = str_replace(" ", " ", $testname2);
					    $testname4 = str_replace("status", "", $testname3);
					    echo '<td onclick='.$onclicks.'><div style=" height:90px; width:200px; background-color:'.$color.'; word-wrap: break-word; color:#000000; border-left-style: solid; border-width: 2px;">'.$testname4.'<br /><br />'.$status.'<input type="hidden" name="datetime" id="datetime" value="'.$testdatetime.'"/><input type="hidden" name="datetime" id="testname" value="'.$testname.'"/></td></div>';                            
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
    <footer id="foot01"></footer>
    </div>
<script src="scripts.js"></script>
</body>
</html>
