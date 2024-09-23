<?php 
    require('connection.php');
    connect();
    $model = $_GET['model'];
    $mac = $_GET['mac'];
    $testdatetime = $_GET['testdatetime'];  
    $testname0 = $_GET['testname'];   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Individual Test Results</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript"></script> 
<script type="text/javascript" src="canvasjs.min.js"></script> 
</head>
<body>
    <center><h1>Individual Test Results</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">            
            <br /> <br />
            <div name="individualtestresultdiv" id="individualtestresultdiv">                  
            <?php
                function plotPoints($pltArray)
                {
                    for($index=0, $num=count($pltArray)-1; $index < $num; ++$index)
					{
                        echo '{ x: '. $index *125e-6 . ', y: '.$pltArray[$index].'},';
                    }
                } 
                $testnamex = str_replace("__status", "", $testname0);
				$smodel1 = str_replace("-", "_", $model);
				$smodel1 = str_replace("m", "", $smodel1);
				$dbhost = 'localhost';
				$dbuser = 'root';
				$dbpass = 'root';
				$dbname = 'TestStandDB';
				$conn  = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
                $query = "show columns FROM m".$smodel1." where FIELD like '".$testnamex."%' and FIELD not like '%__status'";
                $result =  $conn->query($query);   
				$row = mysqli_fetch_assoc($result); 
			    if ((mysqli_num_rows($result)=== 0) or (mysqli_num_rows($result)=== 1))
			    {
				echo '<font color="white">There are currently no results for this test.</font>';
			    }
			    else
			    {
		
				$testing = array();
				$first = 0;
				$isGraph = substr($testname0, strrpos($testname0, '_Graph')); 
				if($isGraph !== "_Graph__status")
				{   
					while($value = mysqli_fetch_array($result))
					{                        
					    if (substr_count($value[0], '__') <= 3 && substr_count($value[0], '__') >= 1)
					    {   
					        $testing[] = $value[0];                          
					    } 
					}            
					if(!$testing)
					{
					    $message = 'ERROR:'.mysql_errno();
					    return $message;
					}
					else
					{                          
					    $newcolumns = implode(",", $testing);         
					    $qStr1 = "select ".$newcolumns." from m".$smodel1." where mac='".$mac."' and testdatetime='".$testdatetime."'"; 
					    $result2 =  $conn->query($qStr1);                                              
					    $ans = mysqli_fetch_array($result2);                         
					    for ($i = 0; $i < count($testing); ++$i)
					    {
					        $testname1 = str_replace("__", " ", $testing[$i]); 
					        $testname2 = str_replace("_", " ", $testname1);
					        $testname3 = str_replace(" ", " ", $testname2);
					        $testname4 = str_replace("status", "", $testname3);
		        		    echo '<font color="#ffffff">'.$testname4.' =    '.$ans[$i].'</font ><br />';                                                                  
					    }          
					}
				}
				else
				{   
					while($value = mysqli_fetch_array($result))
					{                        
					    if (substr_count($value[0], '__') <= 3 && substr_count($value[0], '__') > 1)
					    {   
					        $testing[] = $value[0];                          
					    } 
					}                
					if(!$testing)
					{
					    $message = 'ERROR:'.mysql_errno();
					    return $message;
					}
					else
					{                                                
					    $newcolumns = implode(",", $testing);     
					    $qStr1 = "select ".$newcolumns." from m".$smodel1." where mac='".$mac."' and testdatetime='".$testdatetime."'"; 
					    $result2 =  $conn->query($qStr1);                                              
					    $ans = mysqli_fetch_array($result2);
					    $maxx = trim(str_replace('[',' ',$ans[0]));
					    $actt = trim(str_replace('[',' ',$ans[5]));
					    $minn = trim(str_replace('[',' ',$ans[1]));                        
					    $maxx = preg_split("/\s+/", $maxx); 
					    $actt = preg_split("/\s+/", $actt); 
					    $minn = preg_split("/\s+/", $minn);                                        
					    foreach ($actt AS $index => $value)
					    {
					        $actt[$index] = (float)$actt[$index];
					        $minn[$index] = (float)$minn[$index];
					        $maxx[$index] = (float)$maxx[$index];
					    }
					    $interval = $ans[2]*125e-6/15; 
					    $newinterval = round($interval, 5);
					    $xinterval = $ans[1]*125e-6/15; 
					    $newxinterval = round($xinterval, 5);                                                
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
					    $testnamex1 = str_replace("__", " ", $testnamex); 
					    $testnamex2 = str_replace("_", " ", $testnamex1);
					    $testnamex3 = str_replace(" ", " ", $testnamex2);
					    echo '          text: "'.$testnamex3.'"';
					    echo '          },';
					    echo '          axisX:{';
					    echo '          title: "Time",';
					    echo '          margin: 10,';
					    echo '          titleFontFamily: "comic sans ms",'; 
					    echo '          titleFontSize: 15,';
					    echo '          minimum: 0,';
					    echo '          maximum: '.$ans[2]*125e-6.',';                        
					    echo '          interval:'.$newinterval.',';
					    echo '          intervalType: "millisecond",';
					    echo '          valueFormatString: "##.#####",';
					    echo '          },';
					    echo '          axisY:{';
					    echo '          title: "Units",';
					    echo '          margin: 10,';
					    echo '          titleFontFamily: "comic sans ms",'; 
					    echo '          titleFontSize: 15,';
					    echo '          },';                         
					    echo '          data: [';
					    echo '          {';
					    echo '          type: "line",';
					    echo '          color: "green",';
					    echo '            dataPoints: [';
					                        plotPoints($maxx);                       
					    echo '            ]';
					    echo '          },';
					    echo '          {';
					    echo '          type: "line",';
					    echo '          color: "blue",';
					    echo '            dataPoints: [';
					                      plotPoints($actt);
					    echo '            ]';
					    echo '          },';
					    echo '          {';
					    echo '          type: "line",';
					    echo '          color: "green",';
					    echo '            dataPoints: [';
					                       plotPoints($minn);                        
					    echo '            ]';
					    echo '          },';
					    echo '          ]';
					    echo '      }); ';
					    echo '      chart.render();';
					    echo '}';
					    echo '</script>';                                             
					    echo '<div id="chartContainer" style="height: 400px; width: 100%;"></div>';
					}
				}
	        }
            ?>                
            </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
