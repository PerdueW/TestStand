<?php 
    require('connection.php');
    connect();
    $son = $_GET['son'];
    $tdt = $_GET['tdt'];
    $tstand = $_GET['tstand'];  
    $tstatus = $_GET['tstatus']; 
    $model = $_GET['model'];  
    $mac = $_GET['mac'];  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shop Order Number Test Results</title>
<link href="site.css" rel="stylesheet">  </link>  
<script  src="scripts.js" type="text/javascript">
</script>

</head>
<body>
    <center><h1>Shop Order Number Test Results</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">          
            <label for="son">Shop Order Number:</label>
            <select name="son" id="son" onchange="OnSelectChange(this)" style="width: 175px; text-align: center;">
                <option value = <?php echo $son; ?>><?php echo $son; ?></option>                                
            </select>                        
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="tdt">Test Date & Time:</label>
            <select name="tdt" id="tdt" onchange="statusSelectChange(this)" style="width: 175px; text-align: center;">
                 <option value = <?php echo $tdt; ?>><?php echo $tdt; ?></option>                 
            </select>   
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="mac">Mac:</label>
            <select name="mac" id="mac" onchange="" style="width: 175px; text-align: center;">
                 <option value = <?php echo $mac; ?>><?php echo $mac; ?></option> 
            </select>          
            &nbsp;&nbsp;&nbsp;&nbsp;            
            <label for="model">Model:</label>
            <select name="model" id="model" onchange="" style="width: 175px; text-align: center;">
                 <option value = <?php echo $model; ?>><?php echo $model; ?></option> 
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
        <div name="sonresults" id="sonresults"> 
		<table id="stationinfo">
		<?php
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = 'root';
			$dbname = 'TestStandDB';
			$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
			$teststandinfoq = "select Shop_Order_Number__ShopOrderNumber__text as son, m838SW, m838HW, picSW, picHW, Carrier, family, hwRev, swRev
					  from ".$model." where Shop_Order_Number__ShopOrderNumber__text='".$son."' and testdatetime='".$tdt."'"; 
			$teststandinfor = $conn->query($teststandinfoq); 
			$teststandinfo = mysqli_fetch_array($teststandinfor); 
			
			echo '<table>';
			echo '  <tr>';
			echo '    <td width="177px" height="37px" style="color: black"> Shop Order Number <br/>'.$son.'</td>';
			echo '  </tr>';
			echo '  <tr>';
			echo '    <td width="177px" height="35px" style="color: black"> m838SW<br/>'.$teststandinfo[1].'</td>';
			echo '    <td width="177px" height="35px" style="color: black"> m838HW<br/>'.$teststandinfo[2].'</td>';
			echo '    <td width="177px" height="35px" style="color: black"> picSW<br/>'.$teststandinfo[3].'</td>';
			echo '    <td width="177px" height="35px" style="color: black"> picHW<br/>'.$teststandinfo[4].'</td>';
			echo '  </tr>';
			echo '  <tr>';
			echo '    <td width="177px" height="35px" style="color: black"> Carrier<br/>'.$teststandinfo[5].'</td>';
			echo '    <td width="177px" height="35px" style="color: black"> family<br/>'.$teststandinfo[6].'</td>';
			echo '    <td width="177px" height="35px" style="color: black"> hwRev<br/>'.$teststandinfo[7].'</td>';
			echo '    <td width="177px" height="35px" style="color: black"> swRev<br/>'.$teststandinfo[8].'</td>';
			echo '  </tr>';
			echo '</table> ';
		?>
        </table>
        <br /> 
        <table id="sontestresults">
        <?php
	       $model1 = str_replace("-", "_", $model);  
            $query="show columns FROM ".$model1. " where field REGEXP '__status'";  
            $result = $conn->query($query);  
            $result1 = $conn->query($query);  
            $testing = array();
            $first = 0;
            while($value = mysqli_fetch_array($result))
            {
                if (substr_count($value[0], '__') <= 1)
                {
                    
                    $testing[] = $value[0];
                } 
            }                
            if(!$testing)
            {
                 $message = 'ERROR:'.mysqli_errno(); print 'teststring error';
                 return $message;
            }
            else
            {   
                $newcolumns = implode(",", $testing);           
                $qStr1 = "select ".$newcolumns." from ".$model1." where Shop_Order_Number__ShopOrderNumber__text='".$son."' and testdatetime='".$tdt."'";
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
                        $onclicks = "addCellHandlers4(this)";
                    }
                    else
                    {
                        $onclicks = " ";
                    }
                    $testname1 = str_replace("__", " ", $testname);
                    $testname2 = str_replace("_", " ", $testname1);
                    $testname3 = str_replace(" ", " ", $testname2);
                    $testname4 = str_replace("status", "", $testname3);                            
                    echo '<td onclick='.$onclicks.'><div style=" height:65px; width:175px; background-color:'.$color.'; 
							  color:#000000; border-left-style: solid; border-width: 2px; cursor: pointer;">'.$testname4.'<br />'.$status.
                         '<input type="hidden" name="datetime" id="datetime" value="'.$testdatetime.'"/>
		  				  <input type="hidden" name="datetime" id="testname" value="'.$testname.'"/></td></div>';                            
                    if(($i+1) % 5 == 0)
                    {
                        echo "</tr>\n";
                        $cols = 0;
                    }                            
                }            
            } 
        ?> 
        </table>
        <br />
            <table>
            <?php
                $modelsarray = array();
                $model2 =  $model1;
                $tablesQuery  = "show tables from TestStandDB";
                $tablesresult = $conn->query($tablesQuery);  
                $tablesresultArray = (array)$tablesresult;
                $counter = 0;
                $counter = 0;
                $selects = "";
                $tables = "";
                $wheres = "";
                $place = 0;
                $testing3 = array(); 
                while($value = mysqli_fetch_array($tablesresult))
                { 
                    array_push($modelsarray,$value[0]);
                } 
                $results = array();
                foreach ($modelsarray as $value) 
                { 
                    if (strpos($value, $model2) !== false) 
                    {
                        if($place === 0)
                        {
                            #$selects = $value.".TEST__status as TEST__status";
                            $tables = $value;
                            $wheres = $value.".Shop_Order_Number__ShopOrderNumber__text='".$son."' and ".$value.".testdatetime='".$tdt."' and ";
                            $place = 1;
                            $results[] = $value; 
                        }
                        else 
                        {
                            $testsuite = explode("__", $value);
                            $testsuite = $testsuite[1];
                            $selects = $selects.",".$value.".".$testsuite."__status as ".$testsuite."__status";
                            $tables = $tables.",".$value;
                            $wheres = $wheres." ".$value.".Shop_Order_Number__ShopOrderNumber__text='".$son."' and ".$value.".testdatetime='".$tdt."' and ";
                            $results[] = $value; 
                        }
                    }
                }
                $selects = substr($selects, 1); 
                $wheres = substr($wheres, 0,strrpos($wheres,"and"));
                $query3 = "select ".$selects." from ".$tables." where ".$wheres;
                //echo "query3 = ".$query3."<br />";
                $result3 = mysqli_query($conn, $query3);
                $row = mysqli_fetch_assoc($result3);
                $i = 0;
                foreach($row as $column => $value) 
                {
                    $testname = $column;
                    $status = $value;
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
                        $onclicks = "addCellHandlers4SC(this)";
                    }
                    else
                    {
                        $onclicks = " ";
                    }
                    $testname1 = str_replace("__", " ", $testname);
                    $testname2 = str_replace("_", " ", $testname1);
                    $testname3 = str_replace(" ", " ", $testname2);
                    $testname4 = str_replace("status", "", $testname3);                            
                    echo '<td onclick='.$onclicks.'>
                          <div style=" height:65px; width:175px; background-color:'.$color.'; color:#000000; border-left-style: solid; 
                            border-width: 2px; cursor: pointer;">'.$testname4.'<br />'.$status.
                         '<input type="hidden" name="datetime" id="datetime" value="'.$testdatetime.'"/>
                          <input type="hidden" name="datetime" id="testname" value="'.$testname.'"/></td></div>';                            
                    if(($i+1) % 5 == 0)
                    {
                        echo "</tr>\n";
                        $cols = 0;
                    } 
                    $i = $i + 1;                
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


