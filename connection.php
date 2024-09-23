<?php  
$conn = Null; 
function connect()
{
	$dbhost = '';
	$dbuser = '';
	$dbpass = '';
	$dbname = '';
 	$GLOBALS['conn ']= mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
}

function close()
{
    mysqli_close();
}

function modelQuery()
{
    $modelData = mysqli_query($GLOBALS['conn '],"SELECT model FROM models");
    echo'<option value=""></option>';
    while($record = mysqli_fetch_array($modelData))
    {        
      echo'<option value="'.$record['model'].'">'.$record['model'].'</option>';        
    }       
}

if (isset($_GET['cmd']))
{
    header ('Content-Type: text/xml');
    header ('Cache-Control: no-cache');
    header ('Cache-Control: no-store' , false);
    connect();
    $cmd = $_GET['cmd'];
    if($cmd === "macQuery")
    {
        $model = $_GET['model'];
        macQuery($model);          
    }
    else if($cmd === "datetimeQuery")
    {
        $model = $_GET['model'];
        $mac = $_GET['mac'];
        datetimeQuery($model, $mac);
    }
    else if($cmd === "ModelMacDT")
    {          
        $model = $_GET['model'];
        $mac = $_GET['mac'];
        $datetime = $_GET['testdatetime'];         
        ModelMacDT($model, $mac, $datetime);       
    }
    else if($cmd === "thmQuery")
    {
        $model = $_GET['model'];
        thmQuery($model);          
    }
    else if($cmd === "thmQueryDB")
    { 
        $thmmodel = $_GET['thmmodel'];
        $thmmac = $_GET['thmmac'];
        thmQueryDB($thmmodel, $thmmac);          
    }
    else if($cmd === "thmrtestResult")
    { 
        $thmrmodel = $_GET['thmrmodel'];
        $thmrmac = $_GET['thmrmac'];
        $thmrtestdatetime = $_GET['thmrtestdatetime'];
        $thmrteststand = $_GET['thmrteststand'];
        thmtestResult($thmrmodel, $thmrmac, $thmrtestdatetime, $thmrteststand);
    } 
    else if($cmd === "teststats")
    {     
        $tsrmodel = $_GET['$tssmodel'];
        teststats($tsrmodel);          
    }
    else if($cmd === "testsummary")
    {     
        $tsummodel = $_GET['$tsummodel'];
        testsummary($tsummodel);          
    }
    else if($cmd === "modelstatistics")
    {     
        modelstatistics();          
    }
    else if($cmd === "distinctmodelstatistics")
    {     
        distinctmodelstatistics();          
    }
    else if($cmd === "datetimestatus")
    { 
        $model = $_GET['model'];
        $mac = $_GET['mac'];         
        datetimestatus($model, $mac);       
    }
    else if($cmd === "testbymacgrid")
    { 
        $selectedModel = $_GET['selectedModel'];
        $selectedMac = $_GET['selectedMac'];
        $datetime = $_GET['datetime'];
        $status = $_GET['status'];
        testbymacgrid($selectedModel, $selectedMac, $datetime, $status);
    } 
    else if($cmd === "individualtestresultDB")
    {   
        $indvmodel = $_GET['itrmodel'];
        $indvmac = $_GET['itrmac'];
        $indvdatetime = $_GET['itrdatetime'];
        $indvtest = $_GET['itrclickedcell'];
        individualtestresultDB($indvmodel, $indvmac, $indvdatetime, $indvtest);          
    } 
    else if($cmd === "msbdatetime")
    { 

        $model = $_GET['model'];        
        msbdatetime($model);       
    }
    else if($cmd === "modeldatetimequery")
    {   
        $model = $_GET['model'];
        $startdatetime = $_GET['startdatetime'];
        $enddatetime = $_GET['enddatetime'];
        modeldatetimequery($model, $startdatetime, $enddatetime);          
    }
    else if($cmd === "thmrtestResult2")
    { 
        $thmrmodel = $_GET['thmrmodel'];
        $thmrmac = $_GET['thmrmac'];
        $thmrtestdatetime = $_GET['thmrtestdatetime'];
        thmtestResult2($thmrmodel, $thmrmac, $thmrtestdatetime);         
    }
    else if($cmd === "macsearchquery")
    {
        $mac = $_GET['mac'];
        macsearchquery($mac);
    }
    else if($cmd === "modeldatetimequery2")
    {   
        $model = $_GET['model'];
        $startdatetime = $_GET['startdatetime'];
        $enddatetime = $_GET['enddatetime'];
        $macs = $_GET['macs'];
        modeldatetimequery2($model, $startdatetime, $enddatetime, $macs);          
    }
    else if($cmd === "sonsearchquery")
    {   
        $son = $_GET['son'];
        sonsearchquery($son);              
    }
    else if($cmd === "ficturecarrierfailuresquery")
    {   
        $model = $_GET['model'];
        $startdatetime = $_GET['startdatetime'];
        $enddatetime = $_GET['enddatetime'];
        ficturecarrierfailuresquery($model, $startdatetime, $enddatetime);
       
    }
    else if($cmd === "modeldatetimequery3")
    {   
        $model = $_GET['model'];
        $startdatetime = $_GET['startdatetime'];
        $enddatetime = $_GET['enddatetime'];
	    $macs = $_GET['macs'];
        modeldatetimequery3($model, $startdatetime, $enddatetime, $macs);          
    }
    else if($cmd === "esp32actuals")
    {   
        $model = $_GET['model'];
        esp32actuals($model);          
    }    
    else if($cmd === "exportresults")
    {
        $model = $_GET['model'];
        exportresults($model); 
    }
    else if($cmd === "columnsquery")
    {
        $model = $_GET['model'];
        columnsquery($model); 
    }
    else if($cmd === "mactestfails")
    {   
        $model = $_GET['model'];
        $startdatetime = $_GET['startdatetime'];
        $enddatetime = $_GET['enddatetime'];
        $macs = $_GET['macs'];
        mactestfails($model, $startdatetime, $enddatetime, $macs);          
    }
    
    else if($cmd === "individualtable")
    {   
        $model = $_GET['model'];
        $mac = $_GET['mac'];
        $datetime = $_GET['datetime'];
        $tablename = $_GET['tablename'];
        individualtableDB($model, $mac, $datetime, $tablename);          
    }
    else
    {
       echo("Opps,No Data Available. Please check your inputs and resubmit.  ");
       echo($cmd);
    }      
}  

function macQuery($smodel)
{ 
    $qStr = "SELECT DISTINCT mac FROM m".$smodel." ORDER BY mac";    
    $macData = mysqli_query($GLOBALS['conn '],$qStr); 
    echo'<option value=""></option>';
    while($record = mysqli_fetch_array($macData))
    {
      echo'<option value="'.$record['mac'].'">'.$record['mac'].'</option>';        
    }   
} 

function datetimeQuery($model, $mac)
{
    $qStr = "select testdatetime from m".$model. " where mac='".$mac."'"; 
    $datetimeData = mysqli_query($GLOBALS['conn '],$qStr); 
    echo'<option value=""></option>';
    while($record = mysqli_fetch_array($datetimeData))
    {
      echo'<option value="'.$record['testdatetime'].'">'.$record['testdatetime'].'</option>';        
    }
} 

function ModelMacDT($model, $mac, $testdatetime)
{              
    $qStr = "select * from m".$model. " where mac='".$mac."' and testdatetime='".$testdatetime."'";
    $result = mysqli_query($GLOBALS['conn '],$qStr);   
    if(!$result)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    {
        $i = 0; 
        echo '<table><tr>'; 
        while ($i < mysqli_num_fields($result)) 
        { 
            $meta = mysqli_fetch_field($result, $i); 
            echo '<td>' . $meta->name . '</td>'; 
            $i = $i + 1;               
        } 
        echo '</tr>'; 
        $j = 0; 
        while ($row = mysqli_fetch_row($result)) 
        { 
            echo '<tr>'; 
            $count = count($row); 
            $y = 0; 
            while ($y < $count) 
            { 
                $c_row = current($row); 
                echo '<td><div style="height:25px; overflow-y:scroll">' . $c_row . '</td>'; 
                next($row); $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1;               
        } 
        echo '</table>'; 
        mysqli_free_result($result);
    }     
}   

function thmQuery($smodel)
{ 
    $smodel = str_replace("-", "_", $smodel);
    $qStr = "SELECT DISTINCT mac FROM m".$smodel." ORDER BY mac";      
    $macData = mysqli_query($GLOBALS['conn '],$qStr); 
    echo'<option value=""></option>';
    while($record = mysqli_fetch_array($macData))
    {
      echo'<option value="'.$record['mac'].'">'.$record['mac'].'</option>';        
    }   
}

function thmQueryDB($thmmodel, $thmmac)
{
  $thmmodel1 = str_replace("-", "_", $thmmodel); 
  $qStr = "select mac, testdatetime, teststand, TEST__status from m".$thmmodel1. " where mac='".$thmmac."'";
  $result = mysqli_query($GLOBALS['conn '],$qStr);   
  if(!$result)
  {
      $message = 'ERROR:'.mysqli_errno();
      return $message;
  }
  
  {
      $model = $thmmodel1;
      $i = 0;
      echo '<span></span>';
      echo '<table style="width: 100%;">';
      echo '<tr scope="row"></tr>'; 
      echo '<tr><th style="width: 200px;">MAC </th><th style="width: 200px;">Date-Time</th><th style="width: 200px;">Test Stand</th><th style="width: 200px;">Status</th></tr>'; 
      $j = 0; 
      while ($row = mysqli_fetch_row($result)) 
      { 
          $mystring = "";
          echo '<tr scope="row" style="height:15px; width: 250px" onclick="addRowHandlers()">'; 
          $count = count($row); 
          $y = 0; 
          while ($y < $count) 
          { 
              $c_row = current($row); 
              echo '<style="height:15px; width: 250px; "><td style="cursor: pointer;">' . $c_row . '</td>'; 
              next($row); $y = $y + 1;                   
          } 
          echo '</tr>'; 
          $j = $j + 1;               
       } 
       echo '</table>'; 
       mysqli_free_result($result);
  }        
} 

function thmtestResult($model, $mac, $testdatetime, $teststand)
{ 
    $qStr = "select * from m".$model. " where mac='".$mac."' and TestStand='".$teststand."' and testdatetime='".$testdatetime."'";
    echo   $qStr;       
    $result = mysqli_query($GLOBALS['conn '],$qStr);  

    if(!$result)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    {
        $smodel = $model;
        $i = 0;
        echo '<tr><td style="height:15px; width: 200px">MAC</td><td style="height:15px; width: 200px">Test Date-Time</td><td style="height:15px; width: 200px"> Test Stand </td></tr>';
        $j = 0; 
        while ($row = mysqli_fetch_row($result)) 
        { 
            $mystring = "";
            echo '<tr scope="row" style="width: 300px">'; 
            $count = count($row); 
            $y = 0; 
            while ($y < $count) 
            { 
                $c_row = current($row); 
                echo '<td>' . $c_row . '</td>'; 
                next($row); $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1;               
        } 
        mysqli_free_result($result);
    }     
}

function mysqli_result($res,$row=0,$col=0)
{ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0)
    {
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col]))
	{
            return $resrow[$col];
        }
    }
    return false;
}

function teststats($tsrmodel)
{ 
    $model = str_replace("-", "_", $tsrmodel);  
    $query0="show tables like 'm".$model ."%'"; /// This query, query's the database and returns gets all the tables in the database
    $result0 =  mysqli_query($GLOBALS['conn '], $query0); /// This executes the query and sets a php variable to the result set from the above query.
    if(!$result0)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    {   
        foreach ($result0 as $tablelist)
        {
            foreach ($tablelist as $table) 
            {                
                if(strpos($table, '__') !== false)
                {
                    $testsuiteName = explode("__", $table)[1];
                    $testsuiteName = str_replace("_", " ", $testsuiteName);
                } 
                else
                {
                    $testsuiteName = "General Table";   
                }          
                echo '<tr scope="row" style="width: 300px">'; 
                echo '<tr><th style="width: 350px;">'.$testsuiteName.' Tests</th><th style="width: 100px;"> Attempts</th><th style="width: 100px;"> Fail </th><th style="width: 100px;">Pass</th><th style="width: 100px;">% Fail</th></tr>';
                $query="show columns FROM ".$table." from TestStandDB WHERE Field like '%_pwr' or Field like '%__status' and Field not like 'Shop%'";  /// This query retrieves the columns from the table(s) associated with the selected models 
                $result =  mysqli_query($GLOBALS['conn '], $query);
                if(!$result)
                {
                    $message = 'ERROR:'.mysqli_errno();
                    return $message;
                }
                else  
                {
                    while ($row = mysqli_fetch_row($result)) // This function returns the row result in the results from above for each row in the result set. Ex. Array ( [0] => MacAddr_Scan__Mac_Address__status [1] => text [2] => YES [3] => [4] => [5] => )
                    {   
                        $column = $row[0];                   
                        $query1="Select count(".$column.") from ".$table. " where ".$column."='Fail'";  // This query get the number columns that have fails in their row
                        $FailedQuery = mysqli_query($GLOBALS['conn '], $query1); 
                        $fcount = mysqli_result($FailedQuery,0); 
                        $query2="Select count(".$column.") from ".$table. " where ".$column."='Pass'";  // This query get the number columns that have passed in their row
                        $PassedQuery = mysqli_query($GLOBALS['conn '], $query2); 
                        $pcount = mysqli_result($PassedQuery,0);
                        $c_row = current($row); 
                        $percentfailed = (($fcount/($fcount+$pcount)*100));
                        $roubndedpercentfailed = number_format((float)$percentfailed, 2, '.', '');
                        $numattempts = ($fcount + $pcount);
                        $testname1 = str_replace("__", " ", $c_row);                                                                                                                                
                        $testname2 = str_replace("_", " ", $testname1);
                        $testname3 = str_replace(" ", " ", $testname2);
                        $testname4 = str_replace("status", "", $testname3);
                        echo '<td>' . $testname4 . '</td>'; 
                        echo '<td>' . $numattempts . '</td>';
                        echo '<td>' . $fcount . '</td>';
                        echo '<td>' . $pcount. '</td>';
                        echo '<td>' . $roubndedpercentfailed. '%</td>';
                        next($row); 
                        echo '</tr>'; 
                    }
                }
            }
        }
    }
    mysqli_free_result($result);   
}

function testsummary($tsummodel)
{
    $model = str_replace("-", "_", $tsummodel);  
    $query0="show tables like 'm".$model."%'"; /// This query, query's the database and returns gets all the tables in the database
    //echo "query0 ".$query0."<br />";
    $result0 =  mysqli_query($GLOBALS['conn '], $query0); /// This executes the query and sets a php variable to the result set from the above query.
    if(!$result0)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    {   
        foreach ($result0 as $tablelist)
        {
            foreach ($tablelist as $table) 
            {                
                if(strpos($table, '__') !== false)
                {
                    $testsuiteName = explode("__", $table)[1];
                    $testsuiteName = str_replace("_", " ", $testsuiteName);
                } 
                else
                {
                    $testsuiteName = "General Table";   
                }          
                echo '<tr scope="row" style="width: 300px">'; 
                echo '<tr><th style="width: 300px;">'.$testsuiteName.' Test</th><th style="width: 150px;">Maximum</th><th style="width: 150px;">Average Reading</th><th style="width: 150px;">Minimum&nbsp</th></tr>';
                $query="show columns FROM ".$table." from TestStandDB WHERE Field like '%__actual'";  /// This query retrieves the columns from the table(s) associated with the selected models 
                //echo "query: ".$query."<br />";
                $result =  mysqli_query($GLOBALS['conn '], $query);
                if(!$result)
                {
                    $message = 'ERROR:'.mysqli_errno();
                    return $message;
                }
                else  
                {
                    while ($row = mysqli_fetch_row($result)) // This function returns the row result in the results from above for each row in the result set. Ex. Array ( [0] => MacAddr_Scan__Mac_Address__status [1] => text [2] => YES [3] => [4] => [5] => )
                    {   //print_r ($row[0]); echo " : ";
                        $nums = 0;
                        $column = $row[0];                   
                        $count = count($row[0]); 
                        $test = chop($column,"__actual");
                        //echo "column: ".$column." : ";
                        //echo "table: ".$table." : ";
                        //echo "model: ".$model." : ";
                        //echo "test: ".$test."<br /><br />";
                        $y = 0; 
                        while ($y < $count) 
                        {
                            echo '<tr scope="row" style="width: 250px; cursor: pointer;" onclick="testsummarybargraph()">'; 
                            $avgactuals = mysqli_query($GLOBALS['conn '],"select AVG(".$column.") from ".$table." where ".$test."__status = 'Pass' or ".$test."__status = 'PASSED'");
                                                                        //select AVG(SW1_On__actual) from mSA_12PGW25V__Input_Switches where SW1_On__status= 'Pass' or SW1_On__status = 'PASSED'
                            $avgactresult = mysqli_result($avgactuals,0);
                            $actualmaxs = mysqli_query($GLOBALS['conn '],"select MAX(".$column.") from ".$table." where ".$test."__status = 'Pass' or ".$test."__status = 'PASSED'");
                            $amax = mysqli_result($actualmaxs,0);
                            $actualmins = mysqli_query($GLOBALS['conn '],"select MIN(".$column.") from ".$table." where ".$test."__status = 'Pass' or ".$test."__status = 'PASSED'");
                            $amins = mysqli_result($actualmins,0);
                            $c_row = current($row);
                            $testname1 = str_replace("__", " ", $c_row); 
                            $testname2 = str_replace("_", " ", $testname1);
                            $testname3 = str_replace(" ", " ", $testname2);
                            $testname4 = str_replace("status", "", $testname3);
                            $testname5 = str_replace("actual", "", $testname4);                
                            echo '<td>' . $testname5 . '</td>';     
                            echo '<td>' . round($amax,3) . '</td>'; 
                            echo '<td>' . round($avgactresult,3) . '</td>';                
                            echo '<td>' . round($amins,3). '</td>';
                            echo '<td style="display:none;">' . $c_row . '</td>';
                            next($row); 
                            $y = $y + 1;                   
                        } 
                        echo '</tr>'; 
                        $j = $j + 1; 
                        $nums += 1;
                    } 
                }
            }
        } 
    } 
    mysqli_free_result($result);      
}   

function modelstatistics()
{   
    $query="select * FROM models"; 
    $result = mysqli_query($GLOBALS['conn '],$query);    
    if(!$result)
    {
         $message = 'ERROR:'.mysqli_errno();
         return $message;
    }
    else
    {
        echo '<tr scope="row" style="width: 300px">'; 
        echo '<tr><th>Model</th><th># Attempts</th><th># Passed</th><th># Failed</th><th>% Passed</th><th>% Failed</th></tr>';
        while ($row = mysqli_fetch_row($result)) 
        { 
            $nums = 0;
            $column = $row[0];                   
            $count = count($row[0]); 
            $y = 0; 
            $column = str_replace("-", "_", $column);  
            while ($y < $count) 
            { 
        		$query = "select count(mac) from m".$column;
        		$numtests = mysqli_query($GLOBALS['conn '],$query);
                $numatts = mysqli_result($numtests,0);   
                $query2 =  "select count(mac) from m".$column." where TEST__status = 'PASSED'";           
                $numberpassed = mysqli_query($GLOBALS['conn '], $query2);
                $numpass = mysqli_result($numberpassed,0);
                $numfail = ($numatts - $numpass);
        		$ppass = number_format((($numpass / $numatts) * 100), 2);
        		$pfail = number_format((($numfail / $numatts) * 100), 2);
                $c_row = current($row);
                echo '<td>' . $c_row . '</td>'; 
                echo '<td>' . $numatts . '</td>';
                echo '<td>' . $numpass . '</td>';
                echo '<td>' . $numfail . '</td>';
                echo '<td>' . $ppass . '</td>';
                echo '<td>' . $pfail . '</td>';
                next($row); 
                $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1; 
            $nums += 1;
        } 
        mysqli_free_result($result);      
    } 
}

function distinctmodelstatistics()
{   
    $query="select * FROM models";
    $result = mysqli_query($GLOBALS['conn '],$query);    
    if(!$result)
    {
         $message = 'ERROR:'.mysqli_errno();
         return $message;
    }
    else
    {
        echo '<tr scope="row" style="width: 300px">'; 
        echo '<tr><th>Model</th><th># Attempts</th><th># Passed</th><th># Failed</th><th>% Passed</th><th>% Failed</th></tr>';
        while ($row = mysqli_fetch_row($result)) 
        { 
            $nums = 0;
            $column = $row[0];                   
            $count = count($row[0]); 
            $y = 0; 
	    $column = str_replace("-", "_", $column);  
            while ($y < $count) 
            { 
		$numtested="select count(distinct mac) from m".$column;
		$numbertests = mysqli_query($GLOBALS['conn '],$numtested);
		$numatts = mysqli_result($numbertests,0);
		$pquery="select count(distinct mac) from m".$column." where TEST__status = 'PASSED'";             
                $numberpassed = mysqli_query($GLOBALS['conn '],$pquery);
                $numpass = mysqli_result($numberpassed,0);		
		$numfail = $numatts - $numpass;
		$ppass = number_format((($numpass / $numatts) * 100), 2);
		$pfail = number_format((($numfail / $numatts) * 100), 2);
                $c_row = current($row);
                echo '<td>' . $c_row . '</td>'; 
                echo '<td>' . $numatts . '</td>';
                echo '<td>' . $numpass . '</td>';
                echo '<td>' . $numfail . '</td>';
		echo '<td>' . $ppass . '</td>';
                echo '<td>' . $pfail . '</td>';
                next($row); 
                $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1; 
            $nums += 1;
        } 
        mysqli_free_result($result);  	
    } 
}


function teststatus($model, $mac, $datetime)
{   
    $qStr = "select TEST__status from m".$model. " where mac='".$mac."' and testdatetime='".$datetime."'";
    $result = mysqli_query($GLOBALS['conn '],$qStr);
    echo'<option value=""></option>';
    while($record = mysqli_fetch_array($result))
    {
        echo'<option value="'.$record['TEST__status'].'">'.$record['TEST__status'].'</option>';        
    }   
}

function datetimestatus($model, $mac)
{   
    $qStr = "select concat(m".$model.".testdatetime,', ' , m".$model.".TEST__status) AS testdatetimestatus from m".$model. " where mac='".$mac."'";
    $result = mysqli_query($GLOBALS['conn '],$qStr); 
    echo $qStr;
    echo'<option value=""></option>';
    while($record = mysqli_fetch_array($result))
    {
        echo'<option value="'.$record['testdatetimestatus'].'">'.$record['testdatetimestatus'].'</option>';        
    }   
}

function testbymacgrid($selectedModel, $selectedMac, $datetime, $status)
{
    $query="show columns FROM m".$selectedModel;                    
    $result = mysqli_query($GLOBALS['conn '],$query);  
    $result1 = mysqli_query($GLOBALS['conn '],$query);  
    $testing = array();
    $first = 0;
    while($value = mysqli_fetch_array($result))
    {
        if (substr_count($value[0], '__') <= 3)
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
        $qStr1 = "select ".$newcolumns." from m".$selectedModel." where mac='".$selectedMac."' and testdatetime='".$datetime."'";
        $result2 = mysqli_query($GLOBALS['conn '],$qStr1);                                               
        $ans = mysqli_fetch_array($result2);                        
        for ($i = 0; $i < count($testing); ++$i)
        {     
            $testname = $testing[$i];
            $status = $ans[$i];
            $pass = stripos($status, "Pass");
            $fail = stripos($status, "Fail");                            
            if($pass !== FALSE)
            {
                $color = "#009933"; 
            }
            else if($fail !== FALSE)
            {
                $color = "#CC0000";
            }
            else
            {
                $color = "#ffffff"; 
            }
            $testname1 = str_replace("__", " ", $testname);
            $testname2 = str_replace("_", " ", $testname1);
            $testname3 = str_replace(" ", " ", $testname2);
            $testname4 = str_replace("status", "", $testname3);
            echo '<td onclick=addCellHandlers(this)><div style=" height:65px; width:175px; background-color:'.$color.'; color:#000000; border-left-style: solid; border-width: 1px;">'.			    			    $testname4.'<br />'.$status.'<input type="hidden" name="datetime" id="datetime" 
            value="'.$datetime.'"/><input type="hidden" name="datetime" id="testname" value="'.$testname.'"/></td></div>';                            
            if(($i+1) % 5 == 0)
            {
                echo "</tr>\n";
                $cols = 0;
            }                            
        }            
    } 
}

function individualtestresultDB($indvmodel, $indvmac, $indvdatetime, $indvtest)
{
    $columns = "";
    $place = 0;
    $testname = str_replace("__status", "", $indvtest);
    $colnames = "show columns from m".$indvmodel. " where Field like '".$testname."%'"; 
    $result = mysqli_query($GLOBALS['conn '],$colnames);    
    while ($column = mysqli_fetch_array($result)) 
    {   
        if($place === 0)
        {
            $columns = $column[0];
            $place = 1;
        }
        else 
        {
            $columns = $columns.",".$column[0];
        }
    }    
    $array = explode(',', $columns);
    $i = 0;
    foreach($array as $value)
    {
        $qStr = "select ".$value." from m".$indvmodel." where mac='".$indvmac."' and testdatetime = '".$indvdatetime."'"; 
        $result2 = mysqli_query($GLOBALS['conn '],$qStr);
        while($row = mysqli_fetch_assoc($result2)) 
        {
            foreach ($row as $key => $value)
            {
                $testname1 = str_replace("__status", "", $key);
                $testname2 = str_replace("__type", "", $testname1);   
                $testname3 = str_replace("__", " ", $testname2);
                $testname4 = str_replace("_", " ", $testname3);
                $testname = str_replace(" ", " ", $testname4);
                echo "<font color='white'>".$testname.':  '.$value.'</font><br />';                
            }
        }
        "<br />";
        $i++;
    }  
}

function msbdatetime($model)
{    
    $datetime = "select testdatetime from m".$model." order by testdatetime";    
    $datetimeresults = mysqli_query($GLOBALS['conn '],$datetime);
    echo'<option value=""></option>';
    while($record = mysqli_fetch_array($datetimeresults))
    {
        echo'<option value="'.$record['testdatetime'].'">'.$record['testdatetime'].'</option>';        
    }   
}

function modeldatetimequery($model, $startdatetime, $enddatetime)
{    
    $datetime = "select mac, testdatetime, TEST__status from m".$model." where testdatetime between '".$startdatetime."' and '".$enddatetime."' order by testdatetime";    
    $datetimeresults = mysqli_query($GLOBALS['conn '],$datetime);    
    $numberpassed = mysqli_query($GLOBALS['conn '],"select count(DISTINCT mac) from m".$model." where testdatetime between '".$startdatetime."' and '".$enddatetime."' and TEST__status = 'PASSED'");
    $numpass = mysqli_result($numberpassed,0);    
    $numberfailed = mysqli_query($GLOBALS['conn '],"select count(DISTINCT mac) from m".$model." where testdatetime between '".$startdatetime."' and '".$enddatetime."' and TEST__status = 'FAILED'");
    $numfail = mysqli_result($numberfailed,0);
    $totaltests = ($numpass + $numfail);
    $percentpass = (($numpass / $totaltests)*100);
    $percentfail = (($numfail / $totaltests)*100);    
    if(!$datetimeresults)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    {  
        echo '<label for="ppass"> Percent Pass: </label>  ';
        echo '<input name="" type="text" value="' . number_format((float)$percentpass, 2, '.', '') . '%" readonly style="width: 60px;">';
        echo "<br />";
        echo '<label for="pfail">Percent  Fail: </label>  ';
        echo '<input name="" type="text" value="' . number_format((float)$percentfail, 2, '.', '') . '%" readonly style="width: 60px;">';
        echo "<br />";
        echo '<tr scope="row" style="width: 300px">';         
        $i = 0; 
        echo '<tr><td style="height:15px; width: 200px">MAC</td><td style="height:15px; width: 200px">Test Date-Time</td><td style="height:15px; width: 200px"> Test Status </td></tr>';
        $j = 0; 
        while ($row = mysqli_fetch_row($datetimeresults)) 
        {   
            $mystring = ""; 
            echo '<tr scope="row" style="width: 300px" onclick="addRowHandlers2()">'; 
            $count = count($row);
            $y = 0; 
            while ($y < $count) 
            { 
                $c_row = current($row); 
                echo '<td>' . $c_row . '</td>'; 
                next($row); $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1;               
        } 
        echo '</table>'; 
        mysqli_free_result($datetimeresults); 
    } 
}

function thmtestResult2($thmrmodel, $thmrmac, $thmrtestdatetime)
{   
    $qStr = "select * from m".$thmrmodel. " where mac='".$thmrmac."' and testdatetime='".$thmrtestdatetime."'";   
    $result = mysqli_query($GLOBALS['conn '],$qStr); 
    if(!$result)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    {
        $smodel = $thmrmodel;
        $i = 0;
        echo '<tr><td style="height:15px; width: 200px">MAC</td><td style="height:15px; width: 200px">Test Date-Time</td><td style="height:15px; width: 200px"> Test Status </td></tr>';
        $j = 0; 
        while ($row = mysqli_fetch_row($result)) 
        { 
            $mystring = "";
            echo '<tr scope="row" style="width: 300px">'; 
            $count = count($row); 
            $y = 0; 
            while ($y < $count) 
            { 
                $c_row = current($row); 
                echo '<td>' . $c_row . '</td>'; 
                next($row); $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1;               
        } 
        mysqli_free_result($result);
    }    
}

function macsearchquery($mac)
{
    $mac = preg_replace('/[^\w]/', '', $mac);
    if (preg_match("/^[0-9A-F]+$/",$mac))
    {           
        while (strlen($mac) > 0)
        {
            $sub = substr($mac,0,2);
            $new .= $sub.':';
            $mac = substr($mac,2,strlen($mac));
        }
        $new = substr($new,0,strlen($new)-1);
    }
    else
    {
        $new = preg_replace('[^A-F0-9]',':',$mac);
    }
    $mac = $new;
    
	$conn = mysqli_connect('localhost', 'root', 'root', 'TestStandDB');
	// Check connection
	if (!$conn) 
	{
	    die("Connection failed: " . mysqli_connect_error());
	} 
	// Start Test Code Section
	$models = "SELECT model FROM models where model NOT LIKE '%\__%'";
	$modelsresult = mysqli_query($GLOBALS['conn '], $models);
	$modelcount = mysqli_num_rows($modelsresult);   
	$x = 1;
	if (mysqli_num_rows($modelsresult) > 0) 
	{
	// output data of each row
	    while($row = mysqli_fetch_assoc($modelsresult)) 
	    {	
            $model = str_replace("-", "_", $row["model"]);
		    $mystring.= "SELECT '".$model."' as tablename, mac, testdatetime, TestStand, TEST__status FROM m".$model." where mac='".$mac."'";
		    if($x < $modelcount)
		    {
			    $mystring.= " UNION ";
			    $x = $x + 1;
		    }
		    else
		    {
			    $mystring.= 'order by testdatetime';
		    }			
	    }
	} 
	else 
	{
		echo "0 results";
	}
    #echo "mystring   =  ". $mystring . "<br/>"; 
	$modelsresult = mysqli_query($GLOBALS['conn '], $mystring);
	if(! $modelsresult )
	{
  	    die('Could not retrieve data: ' . mysqli_error());
	}
	
    $result = mysqli_query($GLOBALS['conn '],$mystring);  
    if(!$result)
    {
	$message = 'ERROR:'.mysqli_errno();
	return $message;
    }
    else
    {
        $i = 0;
        $j = 0;
        echo '<tr><td style="height:15px; width: 200px">Model</td><td style="height:15px; width: 200px">MAC</td><td style="height:15px; width: 200px">Test Date-Time</td><td style="height:15px; width: 200px"> Test Stand</td><td style="height:15px; width: 200px"> Test Status</td></tr>';            
        while ($row = mysqli_fetch_row($result)) 
        { 
            echo '<tr scope="row" style="height:15px; width: 250px; cursor: pointer;" onclick="addRowHandlers4()">'; 
            $count = count($row); 
            $y = 0; 
            while ($y < $count) 
            { 
                $c_row = current($row); 
                echo '<style="height:15px; width: 250px"><td>' . $c_row . '</td>'; 
                next($row); $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1;               
         } 
         echo '</table>'; 
         mysqli_free_result($result);
    } 
}


function testsummarybargraphDBquery($model, $testname, $maximum, $minimum, $puretestname)
{
      $smodel1 = str_replace("-", "_", $model);  
      $qStr = "select mac, testdatetime, TestStand from m".$smodel1." where ".$puretestname." between '".$minimum."' and '".$maximum."'";   
      $result = mysqli_query($GLOBALS['conn '],$qStr); 
      if(!$result)
      {
          $message = 'ERROR:'.mysqli_errno();
          return $message;
      }
      else
      {
          $smodel = $smodel1;
          $i = 0;
          echo '<tr>'; 
          while ($i < mysqli_num_fields($result)) 
          { 
              $meta = mysqli_fetch_field($result, $i); 
              echo '<td>' . $meta->name . '</td>'; 
              $i = $i + 1;               
          } 
          echo '</tr>'; 
          $j = 0; 
          while ($row = mysqli_fetch_row($result)) 
          { 
              $mystring = "";
              echo '<tr scope="row" style="width: 250px">'; 
              $count = count($row); 
              $y = 0; 
              while ($y < $count) 
              { 
                  $c_row = current($row); 
                  echo '<td>' . $c_row . '</td>'; 
                  next($row); $y = $y + 1;                   
              } 
              echo '</tr>'; 
              $j = $j + 1;               
           } 
           mysqli_free_result($result);
      }    	
}

function modeldatetimequery2($model, $startdatetime, $enddatetime, $macs)
{   
    $model = str_replace("-", "_", $model); 
    if($macs == 0)
    {
        $datetime = "select mac, testdatetime, TEST__status, teststand from m".$model." WHERE testdatetime in (SELECT MAX(testdatetime) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' GROUP BY mac) order by mac";
    	//echo $datetime."<br />";
    	$datetimeresults = mysqli_query($GLOBALS['conn '],$datetime); 
    	$numtest0 = "select count(distinct mac) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' ";
    	$numtest = mysqli_query($GLOBALS['conn '],$numtest0);
        $numtests = mysqli_result($numtest,0);
    	$numpass = 0;
    	$numfail = 0;
        while($row = mysqli_fetch_array($datetimeresults)) 
    	{
    		if($row[2] == 'PASSED')
    		{
    			$numpass = $numpass + 1;
    		}
    		elseif($row[2] == 'FAILED')
    		{
    			$numfail = $numfail + 1;
    		}      
      	}
    	$datetimeresults = mysqli_query($GLOBALS['conn '],$datetime);  
        $percentpass = (($numpass / $numtests)*100);
        $percentfail = (($numfail / $numtests)*100);	
    	echo '<label for="numtest"><font color="grey">Results may skew due to overlapping pass and fail tests and a MACs final test result</font></label>  ';
    	echo "<br />";
    	$modelmod = str_replace("_", "-", $model); 
    	echo '<label for="numtest">Distinct '.$modelmod."'s: </label>";
    	echo '<font color="white">'.$numtests.'</font>'; 
    	echo "<br />"; 
    }
    else
    {  
    	$datetime = "select mac, testdatetime, TEST__status, TestStand from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' order by mac";
    	$datetimeresults = mysqli_query($GLOBALS['conn '],$datetime); 
    	echo "<br />"; 
    	$numberpassed = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'PASSED'");
        $numpass = mysqli_result($numberpassed,0);    
        $numberfailed = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'FAILED'");
        $numfail = mysqli_result($numberfailed,0);
        $numtest = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59'");
        $numtests = mysqli_result($numtest,0);
        $totaltests = ($numpass + $numfail);
        $percentpass = (($numpass / $totaltests)*100);
        $percentfail = (($numfail / $totaltests)*100);
    	echo '<label for="numtest"> Tests in Range: </label>  ';
    	echo '<font color="white">'.$numtests.'</font>'; 
    	echo "<br />";
    } 
            
    if(!$datetimeresults)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    { 
        echo '<label for="ppass"> Percent Pass: </label>  ';
        echo '<font color="white">'.number_format((float)$percentpass, 2, '.', '').'</font>';
        echo "<br />";
        echo '<label for="pfail">Percent  Fail: </label>  ';
        echo '<font color="white">'.number_format((float)$percentfail, 2, '.', '').'</font>';
        echo "<br />";
	    echo '<tr scope="row" style="width: 250px"></tr>'; 
      	echo '<tr><th style="width: 200px;"> MAC </th><th style="width: 200px;"> Date-Time </th><th style="width: 200px;"> Status </th><th style="width: 200px;"> Test Stand </th></tr>';         
        $i = 0;
        $j = 0; 

        while ($row = mysqli_fetch_row($datetimeresults)) 
        { 
            $mystring = "";
            echo '<tr scope="row" style="width: 250px; cursor: pointer;" onclick="addRowHandlers6()">'; 
            $count = count($row); 
            $y = 0; 
            while ($y < $count) 
            { 
                $c_row = current($row); 		
                echo '<td>' . $c_row . '</td>'; 
                next($row); $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1;               
        } 
        echo '</table>'; 
        mysqli_free_result($datetimeresults);
    }
}

function sonsearchquery($son)
{
	$conn = mysqli_connect('localhost', 'root', 'root', 'TestStandDB');
	if (!$conn) 
	{
	    die("Connection failed: " . mysqli_connect_error());
	}
	$models = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN('Shop_Order_Number__status','Shop_Order_Number__Shop_Order_Number__status','Shop_Order_Number__Shop_Order_Number__type','Shop_Order_Number__Shop_Order_Number__text') AND TABLE_SCHEMA='TestStandDB'";
	$modelsresult = mysqli_query($conn, $models); 
	$modelcount = mysqli_num_rows($modelsresult); 
	$x = 1;
	if (mysqli_num_rows($modelsresult) > 0) 
	{
        $word = "__";
	    while($row = mysqli_fetch_assoc($modelsresult)) 
	    {
            $model1 = str_replace("-", "_", $row['TABLE_NAME']);
    		$model = substr($model1, 1);
            if(strpos($model, $word) !== false)
            {
                pass;
            }
            else
            {
                $mystring.= "SELECT Shop_Order_Number__ShopOrderNumber__text, testdatetime, mac, 'm".$model."' as tablename FROM m".$model." where Shop_Order_Number__ShopOrderNumber__text = '".$son."'";
        		if($x < $modelcount)
        		{
        			$mystring.= " UNION ";
        			$x = $x + 1;
        		}
        		/*else
        		{
        			$mystring.= " order by mac";
        		}	*/
            }	
	    }   
	} 
	else 
	{
		echo "0 results <br />";
	}
    $mystring = preg_replace('/\W\w+\s*(\W*)$/', '$1', $mystring)."\n";
	$modelsresult = mysqli_query($conn, $mystring);
	if(!$modelsresult )
	{
		die('Could not retrieve data: ' . mysqli_error());
	}

	$result = mysqli_query($conn, $mystring); 
	if(!$result)
	{
		$message = 'ERROR:'.mysqli_errno();
		return $message;
	}
	else
	{	
		$i = 0;
		$j = 0;
		echo '<tr><td style="height:15px; width: 200px"> Shop Order Number</td><td style="height:15px; width: 200px">Test Date-Time</td><td style="height:15px; width: 200px">MAC</td><td style="height:15px; width: 200px">Model</td></tr>';         
		while ($row = mysqli_fetch_row($result)) 
		{   
		    echo '<tr scope="row" style="height:15px; width: 250px; cursor: pointer;" onclick="addRowHandlers7()">'; 
		    $count = count($row); 
		    $y = 0; 
		    while ($y < $count) 
		    { 
			$c_row = current($row); 
			echo '<style="height:15px; width: 250px"><td>' . $c_row . '</td>'; 
			next($row); $y = $y + 1;                   
		    } 
		    echo '</tr>'; 
		    $j = $j + 1;               
		 } 
		 echo '</table>'; 
		 mysqli_free_result($result); 
	}
}
function ficturecarrierfailuresquery($model, $startdatetime, $enddatetime)
{   
	$model = str_replace("-", "_", $model);
	$datetime = "select mac, count(TEST__status='FAILED') as fails from m".$model." 
		where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'FAILED' 
		group by mac order by mac ASC";
	$datetimeresults = mysqli_query($GLOBALS['conn '],$datetime); 
  
	if(!$datetimeresults)
	{
		$message = 'ERROR:'.mysqli_errno();
		return $message;
	}
	else
	{
		echo '<tr scope="row" style="width: 250px"></tr>'; 
		echo '<tr><th style="width: 200px;"> MAC </th><th style="width: 200px;"> Number of Failures</th></tr>';         
		$i = 0;
		$j = 0; 

		while ($row = mysqli_fetch_row($datetimeresults)) 
		{   
		    echo '<tr scope="row" style="width: 250px; cursor: pointer;" onclick="testFunction()">'; 
		    $count = count($row); 
		    $y = 0; 
		    while ($y < $count) 
		    { 
			$c_row = current($row); 		
			echo '<td>' . $c_row . '</td>'; 
			next($row); $y = $y + 1;                   
		    } 
		    echo '</tr>'; 
		    $j = $j + 1;               
		} 
		echo '</table>'; 
		mysqli_free_result($datetimeresults);
	}
}
function modeldatetimequery3($model, $startdatetime, $enddatetime, $macs)
{   
    $model = str_replace("-", "_", $model); 
    if($macs == 0)
    {
        $datetime = "select mac, testdatetime, TEST__status, teststand from m".$model."_distinct WHERE testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' group by mac";
    	//echo $datetime."<br />";
    	$datetimeresults = mysqli_query($GLOBALS['conn '],$datetime); 
    	$numtest0 = "select count(distinct mac) from m".$model."_distinct WHERE testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59'";
    	$numberpassed = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model."_distinct where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'PASSED'");
        $numpass = mysqli_result($numberpassed,0);    
        $numberfailed = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model."_distinct where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'FAILED'");
        $numfail = mysqli_result($numberfailed,0); 
        $numtest = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model."_distinct where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59'");
        $numtests = mysqli_result($numtest,0);
        $totaltests = ($numpass + $numfail);
        $percentpass = (($numpass / $totaltests)*100);
        $percentfail = (($numfail / $totaltests)*100);
  	while($row = mysqli_fetch_array($datetimeresults)) 
    	{
    		if($row[2] == 'PASSED')
    		{
    			$numpass = $numpass + 1;
    		}
    		elseif($row[2] == 'FAILED')
    		{
    			$numfail = $numfail + 1;
    		}      
  	}
    	$datetimeresults = mysqli_query($GLOBALS['conn '],$datetime);  	
    	echo '<label for="numtest"><font color="grey">Results may skew due to overlapping pass and fail tests and a MACs final test result</font></label>  ';
    	echo "<br />";
    	$modelmod = str_replace("_", "-", $model); 
    	echo '<label for="numtest">Distinct '.$modelmod."'s: </label>";
    	echo '<font color="white">'.$numtests.'</font>'; 
    	echo "<br />"; 
    }
    else
    {  
    	$datetime = "select mac, testdatetime, TEST__status, TestStand from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' order by mac";
    	$datetimeresults = mysqli_query($GLOBALS['conn '],$datetime); 
    	echo $datetime."<br />";   
        $numberpassed = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'PASSED'");
        $numpass = mysqli_result($numberpassed,0);    
        $numberfailed = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'FAILED'");
        $numfail = mysqli_result($numberfailed,0);
        $numtest = mysqli_query($GLOBALS['conn '],"select count(mac) from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59'");
        $numtests = mysqli_result($numtest,0);
        $totaltests = ($numpass + $numfail);
        $percentpass = (($numpass / $totaltests)*100);
        $percentfail = (($numfail / $totaltests)*100);
    	echo '<label for="numtest"> Tests in Range: </label>  ';
    	echo '<font color="white">'.$numtests.'</font>'; 
    	echo "<br />";
    }             
    if(!$datetimeresults)
    {
        $message = 'ERROR:'.mysqli_errno();
        return $message;
    }
    else
    { 
        echo '<label for="ppass"> Percent Pass: </label>  ';
        echo '<font color="white">'.number_format((float)$percentpass, 2, '.', '').'</font>';
        echo "<br />";
        echo '<label for="pfail">Percent  Fail: </label>  ';
        echo '<font color="white">'.number_format((float)$percentfail, 2, '.', '').'</font>';
        echo "<br />";
        echo '<tr scope="row" style="width: 250px"></tr>'; 
      	echo '<tr><th style="width: 200px;"> MAC </th><th style="width: 200px;"> Date-Time </th><th style="width: 200px;"> Status </th><th style="width: 200px;"> Test Stand </th></tr>';         
        $i = 0;
        $j = 0; 

        while ($row = mysqli_fetch_row($datetimeresults)) 
        { 
            $mystring = "";
            echo '<tr scope="row" style="width: 250px; cursor: pointer;" onclick="addRowHandlers6()">'; 
            $count = count($row); 
            $y = 0; 
            while ($y < $count) 
            { 
                $c_row = current($row); 		
                echo '<td>' . $c_row . '</td>'; 
                next($row); $y = $y + 1;                   
            } 
            echo '</tr>'; 
            $j = $j + 1;               
        } 
        echo '</table>'; 
        mysqli_free_result($datetimeresults);
    }
}

function esp32actuals($smodel)
{
    $columnnames = "";
    $smodel1 = $smodel;
    $hdrsql = "select column_name from information_schema.columns where table_name='m".$smodel1."' and column_name like '%actual'";
    $headers = mysqli_query($GLOBALS['conn '],$hdrsql); 
    while($row = mysqli_fetch_array($headers))
    {
        $columnnames .= $row[0].",";       
    }
    $columnnames = rtrim($columnnames, ",");
    $qStr = "select mac, testdatetime,". $columnnames." from m".$smodel;
    $result = mysqli_query($GLOBALS['conn '],$qStr); 
    $all_property = array();  
    echo '<input type="button" value="Download Excel" onclick="exportresults()" /><br />';
    echo '<table class="data-table"><tr class="data-heading">';  //initialize table tag
    while ($property = mysqli_fetch_field($result)) 
    {
        echo '<td>' . $property->name . '</td>';  //get field name for header
        array_push($all_property, $property->name);  //save those to array
    }
    echo '</tr>'; //end tr tag
    //showing all data
    while ($row = mysqli_fetch_array($result)) 
    {
        echo "<tr>";
        foreach ($all_property as $item) 
        {
            echo '<td class="bock" style="min-width:150px">' . $row[$item] . '</td>'; //get items using property value
        }
        echo "</tr>";
    }
    echo "</table>";
} 

function exportresults($smodel)
{   
    $sql = "select column_name from information_schema.columns where table_name='m".$smodel1."' and column_name like '%actual'";
    $result = $conn->query($sql);
    $headers = $result->fetch_fields();
    foreach($headers as $header) 
    {
        $head[] = $header->name;
    }
    $fp = fopen('php://output', 'w');

    if ($fp && $result) 
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        fputcsv($fp, array_values($head)); 
        foreach($result as $line)
        {
            fputcsv($fp, $line);
        }
        fclose($fp);
        die;
    }
    echo $fp;
    echo "<br />";
    echo $head;
    echo "<br />";
    $exportedActuals = json_encode($fp);
    echo $exportedActuals;
} 

function columnsquery($model)
{   
    $sql = "select column_name from information_schema.columns where table_name='m".$model."'";
    $result = mysqli_query($GLOBALS['conn '],$sql); 
    echo gettype($result);
    $y = 0;
    $j = 0;
    while($row = mysqli_fetch_object($result))
    {
        //echo  $columnname . "<br />";
        $count = count($row); 
        echo "Count = ". $count . "<br />";
        $columnname = $row->column_name;
        echo '<tr scope="row" style="width: 250px; cursor: pointer;" onclick="testFunction()">';         
        $y = 0; 
        while ($y < 5) 
        {   
            echo '<tr scope="row" style="width: 250px; cursor: pointer;" onclick="testFunction()">';  
            while ($y < $count) 
            {         
                echo '<td>' . $columnname . '</td>';  
                $y += 1;                   
            } 
            echo '</tr>';                
        } 
        echo '</table>';         
                        
    } 
} 

function mactestfails($model, $startdatetime, $enddatetime, $macs)
{   
    $model = str_replace("-", "_", $model); 
    $tableQuery = "show tables";
	$tables = mysqli_query($GLOBALS['conn '],$tableQuery); 
	while($row = mysqli_fetch_array($tables))
    { 
        $tableStatuses = "select column_name from information_schema.columns where table_name= '".$row[0]."' and column_name like '%__status' and column_name not like 'TEST%'";
		$statuses = mysqli_query($GLOBALS['conn '],$tableStatuses); 
		while($column = mysqli_fetch_array($statuses))
	    {
	        $columnnames .= $column[0].",";       
	    }
	    $columnnames = rtrim($columnnames, ",");
	    $statusQuery="select mac, ".$columnnames." from ".$row[0]." where testdatetime between '".$startdatetime." 00:00:01' and '".$enddatetime." 23:59:59' group by mac order by mac";
	    #echo $statusQuery;
	    $columnandstatus = mysqli_query($GLOBALS['conn '],$statusQuery); 
	    while($columnsandStatuses = mysqli_fetch_array($columnandstatus))
	    {
	        echo $columnsandStatuses[0]." = ". $columnsandStatuses[1]. "<br />";       
	    }
		echo "<br />";
		echo "<br />";
    }
}
function individualtableDB($model, $mac, $datetime, $tablename)
{
    $columns = "";
    $place = 0;
    $colnames = "show columns from m".$model. " where Field like '".$testname."%'"; 
    $result = mysqli_query($GLOBALS['conn '],$colnames);    
    while ($column = mysqli_fetch_array($result)) 
    {   
        if($place === 0)
        {
            $columns = $column[0];
            $place = 1;
        }
        else 
        {
            $columns = $columns.",".$column[0];
        }
    }    
    $array = explode(',', $columns);
    $i = 0;
    foreach($array as $value)
    {
        $qStr = "select ".$value." from m".$indvmodel." where mac='".$indvmac."' and testdatetime = '".$indvdatetime."'"; 
        $result2 = mysqli_query($GLOBALS['conn '],$qStr);
        while($row = mysqli_fetch_assoc($result2)) 
        {
            foreach ($row as $key => $value)
            {
                $testname1 = str_replace("__status", "", $key);
                $testname2 = str_replace("__type", "", $testname1);   
                $testname3 = str_replace("__", " ", $testname2);
                $testname4 = str_replace("_", " ", $testname3);
                $testname = str_replace(" ", " ", $testname4);
                echo "<font color='white'>".$testname.':  '.$value.'</font><br />';                
            }
        }
        "<br />";
        $i++;
    }  
}
?>	
