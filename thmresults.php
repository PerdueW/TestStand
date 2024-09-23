<?php 
    //require('connection.php');
    //connect();
    $model = $_GET['model'];
    $mac = $_GET['mac'];
    $testdatetime = $_GET['testdatetime'];       
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unit Test Results</title>
<link href="site.css" rel="stylesheet">  </link>  
<script  src="scripts.js" type="text/javascript">
</script>

</head>
<body>
    <center><h1>Unit Test Results</h1></center>

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
            <label for="datetimestatus">Date and Time:</label>
            <select name="datetimestatus" id="datetimestatus" onchange="" style="width: 250px; text-align: center;">
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
            <br /> <br />         
            <div name="thmresults" id="thmresults"> 
        <table id="stationinfo">
        <?php
            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = 'root';
            $dbname = 'TestStandDB';
            $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            $model1 = str_replace("-", "_", $model); 
            $teststandinfoq = "select mac, m838SW, m838HW, picSW, picHW, Carrier, family, hwRev, swRev
                      from m".$model1." where mac='".$mac."' and testdatetime='".$testdatetime."'";
            $teststandinfor = $conn->query($teststandinfoq);
            $teststandinfo = mysqli_fetch_array($teststandinfor);
            echo '<table>';
            echo '  <tr>';
            echo '    <td width="177px" height="37px" style="color: black"> MAC<br/>'.$teststandinfo[0].'</td>';
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
        <table id="thmtestresults">
        <?php
            $model1 = str_replace("-", "_", $model);  
            $model1 = str_replace("m", "", $model1);
            $query="show columns from m".$model1." where field REGEXP '__status'";             
            $result = $conn->query($query);  
            $result1 =$conn->query($query);  
            $testing = array(); 
            $first = 0;
            $TablesQ = "SELECT distinct table_name FROM information_schema.tables WHERE table_schema = 'TestStandDB' and table_name like 'm".$model1."_\_%' and table_name not like '%__OLD%'";
            $TablesR = $conn->query($TablesQ);
            $multiTable = (array) null; 
            while ($row = $TablesR->fetch_row()) 
            {
                $tableName = $row[0];
                $tableName = strstr($tableName, '__');
                $tableName = trim($tableName,'__');
                array_push($multiTable,$tableName);
            }                      
            while($value = mysqli_fetch_array($result))
            {
                if (substr_count($value[0], '__') <= 1)
                {
                    $tableName = str_replace('__status', '', $value[0]);               
                    if(in_array($tableName, $multiTable))
                    {
                        pass;
                    } 
                    else
                    {
                        $testing[] = $value[0];
                    }
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
                $model1 = str_replace("-", "_", $model1);  
                $model1 = str_replace("m", "", $model1);
                $qStr1 = "select ".$newcolumns." from m".$model1." where mac='".$mac."' and testdatetime='".$testdatetime."'"; 
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
                        $onclicks = "addCellHandlers2(this)";
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
                          <input type="hidden" name="testname" id="testname" value="'.$testname.'"/></td></div>';                            
                    if(($i+1) % 5 == 0)
                    {
                        echo "</tr>\n";
                        $cols = 0;
                    }                            
                }            
            }
            $numTablesQ = "SELECT distinct table_name FROM information_schema.tables WHERE table_schema = 'TestStandDB' and table_name like 'm".$model1."_\_%' and table_name not like '%__OLD%'";
            $numTablesR = $conn->query($numTablesQ); 
            $numTablesCount = mysqli_num_rows($numTablesR); 
            $i    = 0;
            $cols = 0;
            if ($numTablesCount > 1)
            {
                while ($row = $numTablesR->fetch_row()) 
                {
                    $tableName = $row[0];
                    $tableOverallstausCol = trim(explode('__', $tableName)[1]);
                    $testname = $tableName;
                    $qStr5 = "select ".$tableOverallstausCol."__status from ".$tableName." where mac='".$mac."' and testdatetime='".$testdatetime."'";
                    $result5 = $conn->query($qStr5);                                            
                    $ans5 = mysqli_fetch_array($result5);                         
                    $status = $ans5[0];
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
                        $onclicks = "";
                    }
                    else
                    {
                        $onclicks = "addCellHandlers10(this)";
                    }
                    $tableOverallstausCol = str_replace("__", " ", $tableOverallstausCol);
                    $tableOverallstausCol = str_replace("_", " ", $tableOverallstausCol);
                    $tableOverallstausCol = str_replace(" ", " ", $tableOverallstausCol);
                    $tableOverallstausCol = str_replace("status", "", $tableOverallstausCol);                               
                    echo '<td onclick='.$onclicks.'>
                          <div style=" height:65px; width:175px; background-color:'.$color.'; color:#000000; border-left-style: solid; 
                            border-width: 2px; cursor: pointer;">'.$tableOverallstausCol.'<br />'.$status.
                         '<input type="hidden" name="datetime" id="datetime" value="'.$testdatetime.'"/>
                          <input type="hidden" name="newtablename" id="newtablename" value="'.$testname.'"/></td></div>';    
                    $cols += 1; 
                    $i += 1;                  
                    if(($i+1) % 5 == 0)
                    {
                        echo "</tr>\n";
                        $cols = 0;
                    } 

                }                
            }
            else
            {
                pass;
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


