<?php 
    require('connection.php');
    connect(); 
    $model = $_GET['model'];
    $startdatetime = $_GET['startdatetime'];      
    $enddatetime = $_GET['enddatetime']; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fixture and Carrier Failures</title>
<link href="site.css" rel="stylesheet">  </link>   
<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script> 
<script src="scripts.js"></script>
<script type="text/javascript" src="canvasjs.min.js"></script>


<script type="text/javascript">
function getparameters() 
{
	document.getElementById("queryrunninglabel").style.display = "block";
	document.getElementById("queryrunninglabel").style.visibility= "hidden";
	var selectedModel = document.getElementById("msdtmodel").value;
	var startdatetime = document.getElementById("msdtstartdate").value;
	var enddatetime = document.getElementById("msdtenddatetime").value;

 	window.location.href="ficturecarrierfailures.php?&model="+selectedModel+"&startdatetime="+startdatetime+"&enddatetime="+enddatetime;
}
</script>
</head>
<body>
    <center><h1>Fixture and Carrier Failures</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">   
	    <label for="msdtmodel">Model:</label>
            <select name="msdtmodel" id="msdtmodel" onchange="" style="width: 250px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>                
            </select>                        
            &nbsp;            
            <label for="msdtstartdatetime">Start Date/Time:</label>
            <input type="text" name="msdtstartdate" id="msdtstartdate" class="tcal" onchange="" style="width: 250px; text-align: center; color:white;">
            &nbsp;
            <label for="msdtenddatetime">End Date/Time:</label>
            <input type="text" name="msdtenddatetime" id="msdtenddatetime" class="tcal" onchange="" style="width: 250px; text-align: center; color:white;">
 	    &nbsp;&nbsp;
            <input type="button" value="submit" onclick="getparameters()" />
	    <br />
	    <label class="queryrunninglabel" id="queryrunninglabel"><br /> Query running...... <br /></label>
	    <br /> 
            <div name="dayweektestresultdiv" id="dayweektestresultdiv"> 
	    <?php
		echo '<font color="white">Model:          '.$model.'</font><br />';
		echo '<font color="white">Start Datetime: '.$startdatetime.'</font><br />';
		echo '<font color="white">End Datetime:   '.$enddatetime.'</font><br />';
		echo '<input type="hidden" id="modelID" name="modelID" value="'.$model.'" style="display:none"><br />';
		echo '<input type="hidden" id="startdatetimeID" name="startdatetimeID" value="'.$startdatetime.'"><br />';
		echo '<input type="hidden" id="enddatetimeID" name="enddatetimeID" value="'.$enddatetime.'"><br />';
		$model = str_replace("-", "_", $model);	
		$query = "select mac, count(TEST__status='FAILED') as fails from m".$model." where testdatetime between '".$startdatetime." 00:00:00' and '".$enddatetime." 23:59:59' and TEST__status = 'FAILED' group by mac"; //echo $query."<br />";
		echo 'Boards with more than 10 failures will not be represented in this chart<br />';
		$result = mysqli_query($GLOBALS['conn '],$query);	
		$failone = 0;$failtwo = 0;$failthree = 0;$failfour = 0;$failfive = 0;$failsix = 0;$failseven = 0;$faileight = 0;$failnine = 0;$failten = 0;
		while ($row = mysqli_fetch_array($result))
		{	
			if($row[1] == '1')
			{
				$failone = $failone + 1; 
			}
			elseif($row[1] == '2')
			{
				$failtwo = $failtwo + 1;
			}  
			elseif($row[1] == '3')
			{
				$failthree = $failthree + 1;
			}
			elseif($row[1] == '4')
			{
				$failfour = $failfour + 1;
			}
			elseif($row[1] == '5')
			{
				$failfive = $failfive + 1;
			} 
			elseif($row[1] == '6')
			{
				$failsix = $failsix + 1;
			} 	
			elseif($row[1] == '7')
			{
				$failseven = $failseven + 1;
			}	
			elseif($row[1] == '8')
			{
				$faileight = $faileight + 1;
			}
			elseif($row[1] == '9')
			{
				$failnine = $failnine + 1;
			}
			elseif($row[1] == '10')
			{
				$failten = $failten + 1;
			}
			else
			{
				$extra = $extra + 1;
			}
				 
		}	
        echo '<br />';           
        echo '<script type="text/javascript">';
		echo 'document.getElementById("queryrunninglabel").style.display = "none";';
		echo 'document.getElementById("queryrunninglabel").style.visibility= "hidden";';
		echo 'window.onload = function () {';
		echo '    var chart = new CanvasJS.Chart("chartContainer",';
		echo '    {';
		echo '      title:{';
		$model1 = str_replace("_", "-", $model);
		echo '	text: "Units Tested/Day from '.$startdatetime.' to '.$enddatetime.' for the m'.$model1.'"';
		echo '    },';
		echo '    axisX:{';
		echo '    interval:1, ';
		echo '	  valueFormatString: "x" ,';
		echo '    labelAngle: 0, ';
		echo '	  title: "Number of Fails",';
		echo '	  gridThickness: 1';
		echo '    },';
		echo '    axisY: {';
		echo '	  title: "Number of Boards"';
		echo '    },';
		echo '    data: [';
		echo '   {     ';   
		echo '	 type: "column",';
		echo '	 click: onClick,';
		echo '   xValueType: "integer",';
		echo '	 dataPoints: [';	
		echo '		{ x: 1, y: '.$failone.',  label: "1"},';
		echo '		{ x: 2, y: '.$failtwo.',  label: "2"},';
		echo '		{ x: 3, y: '.$failthree.',  label: "3"},';
		echo '		{ x: 4, y: '.$failfour.',  label: "4"},';
		echo '		{ x: 5, y: '.$failfive.',  label: "5"},';
		echo '		{ x: 6, y: '.$failsix.',  label: "6"},';
		echo '		{ x: 7, y: '.$failseven.',  label: "7"},';
		echo '		{ x: 8, y: '.$faileight.',  label: "8"},';
		echo '		{ x: 9, y: '.$failnine.',  label: "9"},';
		echo '		{ x: 10, y: '.$failten.',  label: "10"},';
		echo '	]';
		echo '    }';
		echo '    ]';
		echo '});';
		echo '    chart.render();';
		echo '    function onClick(e) {';
		echo '    	getgraphparameters(e.dataPoint.x)';
		echo '    }';
		echo '}';
		echo '</script>';
		echo '<div id="chartContainer" style="height: 450px; width: 100%;">';
		echo '</div>';
	    ?>	    
            </div>            
        <footer id="foot01"></footer>
    </div>
<script src="scripts.js"></script>
<script type="text/javascript">
</script>
</body>
</html>

