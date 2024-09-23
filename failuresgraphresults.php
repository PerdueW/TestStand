<?php 
    require('connection.php');
    connect();
    $model = $_GET['model'];
    $startdatetime = $_GET['startdatetime'];      
    $enddatetime = $_GET['enddatetime']; 
    $numfails = $_GET['numfails'];
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
			echo '<font color="white">Model:          '.$model.'</font><br />';
			echo '<font color="white">Start Datetime: '.$startdatetime.'</font><br />';
			echo '<font color="white">End Datetime:   '.$enddatetime.'</font><br />';
			$query = "select mac, TestStand, Carrier, count(TEST__status='FAILED') as fails from m".$model." where testdatetime between '".$startdatetime."' and '".$enddatetime."' and TEST__status = 'FAILED' group by mac order by mac";  
			//echo 	$query."<br />";	
		        $result = mysql_query($query);
			if(!$result)
			{
			    $message = 'ERROR:'.mysql_errno();
			    return $message;
			}
			else
			{
			    echo '<input style="display:none;" type="text" name="model" id="model" value="'.$model.'" /></td>';
			    echo '<input style="display:none;" type="text" name="failure'.$numfails.'" id="failure'.$numfails.'" value="'.$numfails.'" /></td>';
		            echo '<table id="graphcolumnresultsTable">'; 
		            echo '<tr><td style="height:15px; width: 200px">MAC</td><td style="height:15px; width: 200px">Test Stand</td>
				      <td style="height:15px; width: 200px"> Carrier</td>
				  </tr>'; 	
				          
		      	    while ($row = mysql_fetch_array($result)) 
			    {
				if($row[3] == $numfails)
				{
					echo '<tr scope="row" style="width: 300px; cursor: pointer;"onclick="addRowHandlers5()">';
				    	echo "<td>".$row[0]."</td>";
				    	echo "<td>".$row[1]."</td>";
				    	echo "<td>".$row[2]."</td>";
				    	echo "</tr>";
				}
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
