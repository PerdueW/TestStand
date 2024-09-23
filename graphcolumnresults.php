<?php 
    require('connection.php');
    connect();
    $model = $_GET['model'];
    $testname = $_GET['testname'];      
    $minimum = $_GET['minimum'];  
    $maximum = $_GET['maximum'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Graph Test Results</title>
<link href="site.css" rel="stylesheet">  </link> 
<script  src="scripts.js" type="text/javascript"></script> 
<script type="text/javascript" src="canvasjs.min.js"></script> 
</head>
<body>
    <center><h1>Graph Test Results</h1></center>
    <nav id="nav01"></nav>    
    <div id="main">            
            <div name="graphcolumnresults" id="graphcolumnresults">                  
            <?php
		$model = str_replace("-", "_", $model);
		$query ="select mac, testdatetime, TestStand from m".$model." where ".$testname." between '".$minimum."' and '".$maximum."'"; 		
                $result = mysqli_query($GLOBALS['conn '],$query);
		if(!$result)
	        {
		    $message = 'ERROR:'.mysqli_errno();
		    return $message;
	        }
	        else
	        {
		    echo '<input style="display:none;" type="text" name="model" id="model" value="'.$model.'" /></td>';
		    echo '<input style="display:none;" type="text" name="testname" id="testname" value="'.$testname.'" /></td>';
                    echo '<table id="graphcolumnresultsTable">'; 
                    echo '<tr><td style="height:15px; width: 200px">MAC</td><td style="height:15px; width: 200px">Test Date-Time</td>
				<td style="height:15px; width: 200px"> Test Stand</td></tr>'; 	
		                  
	      	    while ($row = mysqli_fetch_array($result)) 
		    {
			echo '<tr scope="row" style="width: 300px; cursor: pointer;"onclick="addRowHandlers5()">';
                    	echo "<td>".$row[0]."</td>";
                    	echo "<td>".$row[1]."</td>";
                    	echo "<td>".$row[2]."</td>";
                    	echo "</tr>";
               	    }
	            echo '</table>'; 
	            mysql_free_result($result);	            	     
		}	
    	    ?>               
            </div>                     
        </form> 
        <footer id="foot01"></footer>
    </div>
    <script src="scripts.js"></script>
    </body>
</html>
