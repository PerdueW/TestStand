<?php 
    require('connection.php');
    connect(); 
    $model = $_GET['model'];
    $startdatetime = $_GET['startdatetime'];      
    $enddatetime = $_GET['enddatetime'];  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Test Results during given Test Range</title>
<link href="site.css" rel="stylesheet">  </link>   
<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="canvasjs.min.js"></script>
<script type="text/javascript" src="tcal.js"></script> 
<script  src="scripts.js" type="text/javascript"></script> 

<script type="text/javascript">

/*
	This function upon the click of the submit button, collects the model, start date/time, and end date/time
	and passes the values below to the page when calling the page itself.  
*/
function getparameters() 
{
    document.getElementById("queryrunninglabel").style.display = "block";
    document.getElementById("queryrunninglabel").style.visibility= "visible";
    var selectedModel = document.getElementById("msdtmodel").value;
	var startdatetime = document.getElementById("msdtstartdate").value;
	var enddatetime = document.getElementById("msdtenddatetime").value;
    window.location.href="dayweektestresult.php?&model="+selectedModel+"&startdatetime="+startdatetime+"&enddatetime="+enddatetime;
}
</script> 

</head>
<body>
    <center><h1>Daily Test Results during given Test Range</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">   
	    <label for="msdtmodel">Model:</label>
            <select name="msdtmodel" id="msdtmodel" onchange="" style="width: 250px; text-align: center;">
                <option value="" disabled selected>--Select--</option>
                <?php modelQuery(); ?>  <!-- This php function calls the modelQuery function in the connection.php and it returns the list of models in the TestStandDB database-->      
            </select>                        
            &nbsp;            
            <label for="msdtstartdatetime">Start Date/Time:</label>
            <input type="text" name="msdtstartdate" id="msdtstartdate" class="tcal" onchange="" style="width: 250px; text-align: center; color:white;">
            &nbsp;
            <label for="msdtenddatetime">End Date/Time:</label>
            <input type="text" name="msdtenddatetime" id="msdtenddatetime" class="tcal" onchange="" style="width: 200px; text-align: center; color:white;">
 	        &nbsp;&nbsp;
            <input type="button" value="submit" onclick="getparameters()" />  <!-- This javascript function calls the above javscript function to grab the user paramter data and pass the values back to the page -->
	    <br />
	    <label class="queryrunninglabel" id="queryrunninglabel"><br /> Query running...... <br /></label> <!-- Label used to let the user know that a query is running and is not visable if no query is running -->
 	    <br /> 
        <div name="dayweektestresultdiv" id="dayweektestresultdiv"> 
	    <?php
		    echo '<font color="white">Model:          '.$model.'</font><br />';
		    echo '<font color="white">Start Datetime: '.$startdatetime.'</font><br />';
		    echo '<font color="white">End Datetime:   '.$enddatetime.'</font><br />';
		    $model = str_replace("-", "_", $model);	

		    /*
		    	The below query will take the model, start testdatetime, and end testdatetime and query the database and the 
		    	counted number of macs that have been tested between the selected start and end times and groups them based 
		    	on the test date/time. 
		    */
		    $query = "SELECT CONCAT(YEAR(testdatetime),IF(MONTH(testdatetime)<=10,'0',''),(MONTH(testdatetime) - 1), DATE_FORMAT(testdatetime,'%d%H%i')) AS formatted_time, count(distinct(mac)) 
			      FROM m".$model." where testdatetime between '".$startdatetime." 00:00:01' and '".$enddatetime." 23:59:59' group by date(testdatetime)";
		    $result = mysqli_query($GLOBALS['conn '],$query);	
		    /*
		    	The below code creats the initial paramters of the table to display the data and then processes the data
		    	and displays the data as a bar graph  with the Date of the Test on the x-axis and number of units on the
		    	y-axis and vary in color to distinguish between the different dates. The more the dates the thinner the 
		    	bars and the fewer dates the wider the bars.
		    */
            echo '<br />';          
            echo '<script type="text/javascript">';
		    echo 'document.getElementById("queryrunninglabel").style.display = "none";';
		    echo 'document.getElementById("queryrunninglabel").style.visibility= "hidden";';
		    echo 'window.onload = function () {';
		    echo '    var chart = new CanvasJS.Chart("chartContainer",'; // This function calls the Chart function in canvas.js script to create the chart
		    echo '    {';
		    echo '      title:{';
		    $model1 = str_replace("_", "-", $model);
		    echo '	text: "Units Tested/Day from '.$startdatetime.' to '.$enddatetime.' for the m'.$model1.'"'; // Set the header for the table
		    echo '    },';
		    /*
		    	The below code sets the x and y axis formats and the increments for each axis
		    */
		    echo '    axisX:{';
		    echo '    interval:1, ';
		    echo '	  valueFormatString: "DD-MMM-YYYY" ,';
		    echo '    labelAngle: -20, ';
		    echo '	  title: "Date of Tests",';
		    echo '	  gridThickness: 1';
		    echo '    },';
		    echo '    axisY: {';
		    echo '	  title: "Number of Units Tested"';
		    echo '    },';
		    echo '    data: [';
		    echo '   {     ';   
		    echo '	 type: "column",';
		    echo '   xValueType: "dateTime",';
		    echo '	 dataPoints: [';	
		    /*
		    	This while loop, loops over the results and extractsthe data and sets the year, month, and day and then construct 
		    	the date time on to yyyyy-mm-dd format.
		    */
		    while ($row=mysqli_fetch_array($result)) 
		    {
		       $newdate = str_replace("-", ", ", $row[0]);
		       $year = substr($newdate, 0,4);
		       $month = substr($newdate, 4,-6);
		       $day = substr($newdate, 6,-4);
		       $newdate1 = $year.", ".$month.", ".$day;
		       echo '{ x: new Date('.$newdate1 .'), y: '.$row[1].'},'; 
		    }	
		    echo '	]';
		    echo '    }';
		    echo '    ]';
		    echo '});';
		    echo '    chart.render();'; // This function calls the render function in canvas.js script to display the chart
		    echo '}';
		    echo '</script>';
		    echo '<div id="chartContainer" style="height: 300px; width: 100%;">';
		    echo '</div>';
	    ?>	    
        </div>            
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
