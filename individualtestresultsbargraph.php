<?php 
    require('connection.php');
    connect();
    $model = $_GET['model'];
    $testname = $_GET['testname'];
    $maximum = $_GET['maximum'];  
    $minimum = $_GET['minimum'];  
    $puretestname = $_GET['puretestname']; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Individual Test Results Graph</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript"></script> 
<script type="text/javascript" src="canvasjs.min.js"></script>

<script type="text/javascript">

</script> 

</head>
<body>
    <center><h1>Individual Test Results Graph</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">            
            <br />
            <div name="individualtestresultdiv" id="individualtestresultdiv">                  
            <?php
        $testname  = str_replace("__actual", "", $puretestname);
		$smodel1 = str_replace("-", "_", $model);
        $query ="select distinct ".$testname."__max, ".$testname."__min from m".$smodel1." WHERE ".$testname."__max IS NOT NULL and ".$testname."__min IS NOT NULL"; 		
        $result = mysqli_query($GLOBALS['conn '],$query);
		$row = mysqli_fetch_row($result);
		$maximum = $row[0];
		$minimum = $row[1]; 
		$query1="select count(*) from m".$smodel1." where ".$testname."__max='".$maximum."' and ".$testname."__min= '".$minimum."'"; 
		$result1 = mysqli_query($GLOBALS['conn '],$query1);		
		$row1 = mysqli_fetch_row($result1); 
		$numtests = $row1[0];
		$numpoints = 15;
		$testnamex1 = str_replace("__", " ", $testname ); 
                $testnamex2 = str_replace("_", " ", $testnamex1);
                $testnamex3 = str_replace(" ", " ", $testnamex2);
		echo "<font color='white'> Model:  &nbsp;&nbsp;&nbsp;&nbsp; ".$model."</font><br />";
		echo "<font color='white'> Test Name:  &nbsp;&nbsp;&nbsp;&nbsp; ".$testnamex3."</font><br />";
		echo "<font color='white'> Number of tests(Distinct Macs)= ".$numtests."</font><br />";
		echo "<font color='white'> Maximum value   = " . $maximum . "</font><br />";
	    	echo "<font color='white'> Minimum value   = " . $minimum . "</font><br />";
		$qmax = ($maximum *((100+$numpoints)/100));
		$qmin = 0;           
		echo "<br />";
		echo '<script type="text/javascript">';
                echo 'window.onload = function ()'; 
                echo '{';
                echo '    var chart = new CanvasJS.Chart("chartContainer", ';
                echo '    {';
                echo '    height: 400,';
                echo '    width: 1000,';
                echo '    zoomEnabled: true,';
                echo '          colorSet: "plotcolors",';
                echo '          title:{';
                $testnamex1 = str_replace("__", " ", $testname ); 
                $testnamex2 = str_replace("_", " ", $testnamex1);
                $testnamex3 = str_replace(" ", " ", $testnamex2);
                echo '          text: "'.$testnamex3.'"';
                echo '          },';                        
                echo '          data: [';
                echo '          {';
                echo '          type: "column",';
                echo '          color: "green",';
                echo '            dataPoints: [';

		$sqmax = ($qmin + 0.02);
    	$sqmin = $qmin;		
		for($x=0; $sqmin<($minimum-0.02); $x++ )
		{		    		    
		    $pbquery = "select count(".$testname."__actual) from m".$smodel1." where ".$testname."__actual between '".$sqmin."' and '".$sqmax."'";		    
		    $presult = mysqli_query($GLOBALS['conn '],$pbquery);
		    $prow1 = mysqli_fetch_row($presult);
		    echo '        { y: '.$prow1[0].', label: "'.round($sqmin,3).' - '.round($sqmax,3).'", click: function(){graphcolumnResults("'.$smodel1.'", '.$sqmin.', '.$sqmax.', "'.$puretestname.'")} },';
		    $sqmax += 0.02;
		    $sqmin += 0.02;
		    
		    
		}
		// Main column that uses the hardcoded max and min to find the number of tests within that range.
		$pquery = "select count(".$testname."__actual) from m".$smodel1." where ".$testname."__actual between '".$minimum."' and '".$maximum."'";
	    	$presult = mysqli_query($GLOBALS['conn '],$pquery);
	    	$prow1 = mysqli_fetch_row($presult); 
		
		echo '           { y: '.$prow1[0].', label: "'.round($minimum,3).' - '.round($maximum,3).'", 
					click: function(){graphcolumnResults("'.$smodel1.'", '.$minimum.', '.$maximum.', "'.$puretestname.'")} },';
		//

		$ssqmax = ($maximum+0.02);
		$ssqmin = ($maximum);
		for($x=0; $ssqmin<($qmax-0.02); $x++ )
		{		    		    
		    $paquery = "select count(".$testname."__actual) from m".$smodel1." where ".$testname."__actual between '".$ssqmin."' and '".$ssqmax."'";
		    $presult = mysqli_query($GLOBALS['conn '],$paquery);
		    $prow1 = mysqli_fetch_row($presult);
		    echo '        { y: '.$prow1[0].', label: "'.round($ssqmin,3).' - '.round($ssqmax,3).'", click: function(){graphcolumnResults("'.$smodel1.'", '.$ssqmin.', '.$ssqmax.', "'.$puretestname.'")} },';
		    $ssqmax += 0.02;
		    $ssqmin += 0.02;
		    
		}
		                           
                echo '            ]';
		echo '          }';
                echo '          ]';
                echo '      }); ';
                echo '      chart.render();';
                echo '}';
                echo '</script>';                                             
                echo '<div id="chartContainer" style="height: 400px; width: 100%;"></div>';
            	?>               
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
