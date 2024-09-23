<?php 
    require('connection.php');
    connect();
    $son = $_GET['son'];
    $tdt = $_GET['tdt'];
    $mac = $_GET['mac'];  
    $tname = $_GET['tname'];
    $model = $_GET['model']; 
    $tablename = $_GET['tablename']; 
    if (strpos($model, '__') !== false) 
   	{
	    $displayModel = (explode('__',$model))[0];
	} 
	else
	{
		$displayModel = $model;
	}      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Individual Shop Order </title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript"></script> 
<script type="text/javascript" src="canvasjs.min.js"></script> 
</head>
<body>
    <center><h1>Individual Shop Order </h1></center>
    <nav id="nav01"></nav>    
    <div id="main"> 
       <label for="son">Shop Order NUmber:</label>
        <select name="son" id="son" onchange="" style="width: 125px; text-align: center;">
            <option value = <?php echo $son; ?>><?php echo $son; ?></option>                                
        </select>                        
        &nbsp;&nbsp;&nbsp;&nbsp;            
        <label for="tdt">Test date & Time:</label>
        <select name="tdt" id="tdt" onchange="" style="width: 200px; text-align: center;">
             <option value = <?php echo $tdt; ?>><?php echo $tdt; ?></option>                 
        </select>            
        &nbsp;&nbsp;&nbsp;&nbsp;            
        <label for="mac">MAC:</label>
        <select name="mac" id="mac" onchange="" style="width: 200px; text-align: center;">
             <option value = <?php echo $mac; ?>><?php echo $mac; ?></option> 
        </select> 
        <input type="hidden" id="model" name="model" value="<?php echo $model; ?>">
        <input type="hidden" id="tablename" name="tablename" value="<?php echo $tablename; ?>">
        &nbsp;&nbsp;&nbsp;&nbsp;    
        <label for="displayModel">Model:</label>
        <select name="displayModel" id="displayModel" onchange="" style="width: 200px; text-align: center;">
             <option value = <?php echo $displayModel; ?>><?php echo $displayModel; ?></option> 
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
    	<div name="individualSONdiv" id="individualSONdiv">  
		    <table id="individualSONtable"> 
			<?php 
		       	$testnamex = str_replace("__status", "", $tname);
		       	if (strpos($tablename, '__') !== false) 
		       	{
				    $query="show columns FROM ".$tablename." where FIELD like '%__status' and FIELD not like 'Shop%'"; 
				} 
				else
				{
					$query="show columns FROM ".$model." where FIELD like '".$testnamex."%' and FIELD like '%__status' and FIELD not like 'Shop%'"; 
				}
		        //echo "<br /> query: ".$query."<br />";
		        $result = mysqli_query($GLOBALS['conn '],$query);     
		        $result1 = mysqli_query($GLOBALS['conn '],$query);  
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
					    if (substr_count($value[0], '__') <= 3 && substr_count($value[0], '__') >= 1)
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
					    if (strpos($tablename, '__') !== false) 
				       	{
						    $qStr1 = "select ".$newcolumns." from ".$tablename." where Shop_Order_Number__ShopOrderNumber__text='".$son."' and testdatetime='".$tdt."'"; 
						} 
						else
						{
							$qStr1 = "select ".$newcolumns." from ".$tablename." where Shop_Order_Number__ShopOrderNumber__text='".$son."' and testdatetime='".$tdt."'"; 
						}
					    //echo "<br /> qStr1: ".$qStr1."<br />"; 
					    $result2 = mysqli_query($GLOBALS['conn '],$qStr1);                                               
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
					            $onclicks = "addCellHandlers5(this)";
					        }
					        else
					        {
					            $onclicks = " ";
					        }
					        $testname1 = str_replace("__", " ", $testname); 
					        $testname2 = str_replace("_", " ", $testname1);
					        $testname3 = str_replace(" ", " ", $testname2);
					        $testname4 = str_replace("status", "", $testname3);
					        echo '<td onclick='.$onclicks.'><div style=" height:90px; width:200px; background-color:'.$color.'; word-wrap: break-word; color:#000000; 
								  border-left-style: solid; border-width: 2px;">'.$testname4.'<br /><br />'.$status.
					             '<input type="hidden" name="datetime" id="datetime" value="'.$tdt.'"/>
								  <input type="hidden" name="datetime" id="testname" value="'.$testname.'"/></td>
								  </div>';                            
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
	<input type="hidden" name="model" id="model" value="<?php echo $smodel; ?>">            
</form>              
<footer id="foot01"></footer>
</div>
<script src="scripts.js"></script>
</body>
</html>
