document.getElementById("foot01").innerHTML =
"<p>&copy;  2014 - " + new Date().getFullYear() + " VALCOM, Inc. All rights reserved.</p>";

document.getElementById("nav01").innerHTML =
"<ul id='menu'>" +
"<li><a href='macsearch.php'>Individual MAC Search</a></li>" +
"<li><a href='modelsearchbydatetime2.php'>Model Search By Datetime</a></li>" +
"<li><a href='index.php'>Test History by MAC</a></li>" +
"<li><a href='teststatistics.php'>Test Statistics</a></li>" +
"<li><a href='testsummary.php'>Test Summary</a></li>" +
"<li><a href='shopordersearch.php'>Shop Order Number Search</a></li>" +
"<li><a href='dayweektestresult.php'>Daily Test Results</a></li>" +
"<li><a href='ficturecarrierfailures.php'>Fixture and Carrier Failures</a></li>" +
"<li><a href='esp32values.php'> ESP32 Test Results </a></li>" +
"<li><a href='macs_and_test_fails.php'> MACs Test Fails </a></li>" +
"</ul>";

function queryrunning() 
{   
}

function OnSelectChange(select) 
{    
    var selectedModel = select.options[select.selectedIndex]; 
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("mac").innerHTML=xmlhttp.responseText;  
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=macQuery&model="+selectedModel.value, true);
    xmlhttp.send();
}
   
function macSelectChange(macselect) 
{ 
    var selectedModel = document.getElementById("model");
    var selectedMac = macselect.options[macselect.selectedIndex];   
    var xmlhttp;    
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("datetime").innerHTML=xmlhttp.responseText;             
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=datetimeQuery&model="+selectedModel.value+
                       "&mac="+selectedMac.value, true);
    xmlhttp.send();  
}

function statusSelectChange()
{   
    var selectedModel = document.getElementById("model").value; 
    var selectedMac = document.getElementById("mac").value;
    var xmlhttp;  
      
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("datetimestatus").innerHTML=xmlhttp.responseText;            
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=datetimestatus&model="+selectedModel+
                       "&mac="+selectedMac, true);    
    xmlhttp.send();    
}

function queryDB()
{ 
    var selectedModel = document.getElementById("model").value; 
    var selectedMac = document.getElementById("mac").value;
    var selectedDT = document.getElementById("datetime").value;
    var xmlhttp;  
        
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("results").innerHTML=xmlhttp.responseText;             
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=ModelMacDT&model="+selectedModel+
                       "&mac="+selectedMac+"&testdatetime="+selectedDT, true);
    xmlhttp.send();  
}

function thmmodelSelectChange(select) 
{    
    var selectedModel = select.options[select.selectedIndex]; 
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("thmmac").innerHTML=xmlhttp.responseText;  
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=thmQuery&model="+selectedModel.value, true);
    xmlhttp.send();
}
    
function thmqueryDB()
{
    document.getElementById("queryrunninglabel").style.display = "block";
    document.getElementById("queryrunninglabel").style.visibility= "visible";  
    var thmselectedModel = document.getElementById("thmmodel").value; 
    var thmselectedMac = document.getElementById("thmmac").value;
    var xmlhttp;  
        
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
      if (xmlhttp.readyState===4 && xmlhttp.status===200)
      { 
	  document.getElementById("queryrunninglabel").style.display = "none";
    	  document.getElementById("queryrunninglabel").style.visibility= "hidden";            
          document.getElementById("thmTABLEresults").innerHTML=xmlhttp.responseText;             
      }
    };    
    xmlhttp.open("GET","connection.php?cmd=thmQueryDB&thmmodel="+thmselectedModel+
                       "&thmmac="+thmselectedMac, true);
    xmlhttp.send();  
}

function addRowHandlers() 
{
    var table = document.getElementById("thmTABLEresults");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
                    var thmrmodel = document.getElementById("thmmodel").value;                                        

                    var cell = row.getElementsByTagName("td")[0];
                    var thmrmacid = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[1];
                    var thmrdatetimeid = cell.innerHTML;

                    var cell = row.getElementsByTagName("td")[2];
                    var thmrteststandid = cell.innerHTML;                                        

                    thmrqueryDBresult(thmrmodel, thmrmacid, thmrdatetimeid, thmrteststandid);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);        
    }    
}

function thmrqueryDBresult(thmrmodel, thmrmacid, thmrdatetimeid, thmrteststandid)
{ 
    var thmrselectedModel = thmrmodel; 
    var thmrselectedMac = thmrmacid;
    var thmrselectedDT = thmrdatetimeid;
    var thmrselectedTS = thmrteststandid;
    var xmlhttp;      
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            window.location.assign("thmresults.php?&model=" + thmrselectedModel + 
                                    "&mac=" + thmrselectedMac + " &testdatetime=" + thmrselectedDT );          
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=thmrtestResult&thmrmodel="+thmrselectedModel+
                       "&thmrmac="+thmrselectedMac+"&thmrtestdatetime="+thmrselectedDT+
                       "$thmrteststand="+thmrselectedTS, true);  
    xmlhttp.send();     
}

function teststats()
{ 
    document.getElementById("queryrunninglabel2").style.display = "block";
    document.getElementById("queryrunninglabel2").style.visibility= "visible";     
    var tsselectedModel = document.getElementById("tsmodel").value; 
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
            document.getElementById("queryrunninglabel2").style.display = "none";
    	    document.getElementById("queryrunninglabel2").style.visibility= "hidden"; 
            document.getElementById("teststatsresultsSection").innerHTML=xmlhttp.responseText;   
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=teststats&$tssmodel="+tsselectedModel, true);
    xmlhttp.send();    
}

function testsummary()
{
    document.getElementById("queryrunninglabel2").style.display = "block";
    document.getElementById("queryrunninglabel2").style.visibility= "visible";   
    var tsumselectedModel = document.getElementById("tsummodel").value; 
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
            document.getElementById("queryrunninglabel2").style.display = "none";
    	    document.getElementById("queryrunninglabel2").style.visibility= "hidden"; 
            document.getElementById("testssumresultsSection").innerHTML=xmlhttp.responseText;   
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=testsummary&$tsummodel="+tsumselectedModel, true);
    xmlhttp.send();    
}

function modelstatistics()
{
    document.getElementById("queryrunninglabel").style.display = "block";
    document.getElementById("queryrunninglabel").style.visibility= "visible";     
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
            document.getElementById("queryrunninglabel").style.display = "none";
    	    document.getElementById("queryrunninglabel").style.visibility= "hidden"; 
            document.getElementById("modelstatisticsSectiontable").innerHTML=xmlhttp.responseText;   
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=modelstatistics", true);
    xmlhttp.send();   
}

function distinctmodelstatistics()
{ 
    document.getElementById("queryrunninglabel1").style.display = "block";
    document.getElementById("queryrunninglabel1").style.visibility= "visible";    
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
	    	document.getElementById("queryrunninglabel1").style.display = "none";
    	    document.getElementById("queryrunninglabel1").style.visibility= "hidden"; 
            document.getElementById("distinctmodelstatisticsSectiontable").innerHTML=xmlhttp.responseText;   
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=distinctmodelstatistics", true);
    xmlhttp.send();   
}


function testbymacgrid()
{
    var selectedModel = document.getElementById("model").value; 
    var selectedMac = document.getElementById("mac").value;
    var selecteddatetimestatus = document.getElementById("datetimestatus").value; 
    var splittedstatus = selecteddatetimestatus.split(",");
    var datetime = splittedstatus[0];
    var status = splittedstatus[1];
    var xmlhttp;    
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
            window.location.assign("thmresults.php?&model=" + selectedModel + 
                                  "&mac=" + selectedMac + " &testdatetime=" + datetime ); 
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=testbymacgrid&selectedModel="+selectedModel+
                       "&selectedMac="+selectedMac+"&datetime="+datetime+"&status="+status, true);               
    xmlhttp.send();        
}

function addCellHandlers() 
{   
    var model = document.getElementById("model"), mymodelValue = model.value;
    var mac = document.getElementById("mac"), mymacValue = mac.value;
    var datetimestatus = document.getElementById("datetimestatus"), mydatetimestatusValue = datetimestatus.value;
    var splittedstatus = mydatetimestatusValue.split(",");
    var datetime = splittedstatus[0];
    var status = splittedstatus[1];
    var table = document.getElementById("thmgtestresults");
    var cells = table.getElementsByTagName("td");
    var rows = table.getElementsByTagName("tr");
    for (var i=0,len=cells.length; i<len; i++)
    {        
        cells[i].onclick = function()
        {
            var clickedcell = (this.innerHTML);            
            individualtestresult(mymodelValue, mymacValue, datetime, clickedcell); 
        }
    }      
}

function individualtestresult(mymodelValue, mymacValue, datetime, clickedcell)
{    
    var itrmodel = mymodelValue; 
    var itrmac = mymacValue;
    var itrdatetime = datetime;
    var splittedcellvalue = clickedcell.match(">(.*)<br>");
    var itrclickedcell = splittedcellvalue[1];
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            var individualtestresult=xmlhttp.responseText;
            window.location.assign('individualtestresult.php?data='+individualtestresult);           
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=individualtestresultDB&itrmodel="+itrmodel+"&itrmac="+itrmac+"&itrdatetime="+itrdatetime+"&itrclickedcell="+itrclickedcell, true);                         
    xmlhttp.send();  
}

function datetimequery()
{
    var selectedModel = document.getElementById("msdtmodel").value; 
    var xmlhttp;            
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("msdtstartdate").innerHTML=xmlhttp.responseText; 
            document.getElementById("msdtenddatetime").innerHTML=xmlhttp.responseText;
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=msbdatetime&model="+selectedModel, true);
    xmlhttp.send();       
}

function modeldatetimequery()
{
    var selectedModel = document.getElementById("msdtmodel").value;
    var startdatetime = document.getElementById("msdtstartdate").value;
    var enddatetime = document.getElementById("msdtenddatetime").value;
    var xmlhttp;      
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("dtmresultstable").innerHTML=xmlhttp.responseText; 
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=modeldatetimequery&model="+selectedModel+
                    "&startdatetime="+startdatetime+"&enddatetime="+enddatetime, true);
    xmlhttp.send();      
}

function addRowHandlers2() 
{
    var table = document.getElementById("dtmresultstable");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
                    var thmrmodel = document.getElementById("msdtmodel"), mymodelValue = msdtmodel.value;                                        

                    var cell = row.getElementsByTagName("td")[0];
                    var thmrmacid = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[1];
                    var thmrdatetimeid = cell.innerHTML;                                      
                    
                    thmrqueryDBresult2(mymodelValue, thmrmacid, thmrdatetimeid);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);          
    }    
}

function thmrqueryDBresult2(mymodelValue, thmrmacid, thmrdatetimeid)
{
    var thmrselectedModel = mymodelValue; 
    var thmrselectedMac = thmrmacid;
    var thmrselectedDT = thmrdatetimeid;
    var xmlhttp;    
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            window.location.assign("thmresults.php?&model=" + thmrselectedModel + 
                                    "&mac=" + thmrselectedMac + " &testdatetime=" + thmrselectedDT );            
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=thmrtestResult2&thmrmodel="+thmrselectedModel+
                       "&thmrmac="+thmrselectedMac+"&thmrtestdatetime="+thmrselectedDT, true);  
    xmlhttp.send();  
    
}

function addCellHandlers2(thisCell) 
{ 
    var model = document.getElementById("model"), mymodelValue = model.value;                                        
    var mac = document.getElementById("mac"), mymacValue = mac.value;
    var datetime = document.getElementById("datetime"), mydatetimeValue = datetime.value;
    var cell = thisCell.getElementsByTagName("input");
    var mytestnameValue = cell[1].getAttribute("value");
    individualtestresult2(mymodelValue, mymacValue, mydatetimeValue, mytestnameValue);    
}

function individualtestresult2(mymodelValue, mymacValue, datetime, mytestnameValue)
{    
    var itrmodel = mymodelValue; 
    var itrmac = mymacValue;
    var itrdatetime = datetime;
    var itrtestname = mytestnameValue;
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            var individualtestresult=xmlhttp.responseText;
            window.location.assign("individualtest.php?&model=" + itrmodel + 
                                    "&mac=" + itrmac + " &testdatetime=" + itrdatetime +"&testname=" + itrtestname);           
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=individualtestresultDB&itrmodel="+itrmodel+
                       "&itrmac="+itrmac+"&itrdatetime="+itrdatetime+
                       "&itrclickedcell="+itrtestname, true);                      
    xmlhttp.send();  
}

function addCellHandlers3(thisCell) 
{ 
    var model = document.getElementById("model"), mymodelValue = model.value;                                        
    var mac = document.getElementById("mac"), mymacValue = mac.value;
    var datetime = document.getElementById("datetime"), mydatetimeValue = datetime.value;
    var cell = thisCell.getElementsByTagName("input");
    var mytestnameValue = cell[1].getAttribute("value"); 
    individualtestresult3(mymodelValue, mymacValue, mydatetimeValue, mytestnameValue);    
}

function individualtestresult3(mymodelValue, mymacValue, datetime, mytestnameValue)
{    
    var itrmodel = mymodelValue; 
    var itrmac = mymacValue;
    var itrdatetime = datetime;
    var itrtestname = mytestnameValue; 
    var xmlhttp; 
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {     
            var individualtest=xmlhttp.responseText;
            window.location.assign("individualtestresult.php?&model=" + itrmodel + 
                                    "&mac=" + itrmac + " &testdatetime=" + itrdatetime + " &testname=" + itrtestname);            
        } 
    };    
    xmlhttp.open("GET","connection.php?cmd=individualtestresultDB&itrmodel="+itrmodel+
                       "&itrmac="+itrmac+"&itrdatetime="+itrdatetime+
                       "&itrclickedcell="+itrtestname, true);                        
    xmlhttp.send();  
}

function macsearchquery(teststr)
{ 
    document.getElementById("queryrunninglabel").style.display = "block";
    document.getElementById("queryrunninglabel").style.visibility= "visible";  
    var selectedMac = teststr;
    var xmlhttp;  
      
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
	        document.getElementById("queryrunninglabel").style.display = "none";
            document.getElementById("queryrunninglabel").style.visibility= "hidden";             
            document.getElementById("macsearchquerytable").innerHTML=xmlhttp.responseText;            
        }
    };   
    xmlhttp.open("GET","connection.php?cmd=macsearchquery&mac="+selectedMac, true);    
    xmlhttp.send();    
}

function addRowHandlers3() 
{
    var table = document.getElementById("macsearchquerytable");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
                    var thmrmodel = document.getElementById("msmodel").value;                                        

                    var cell = row.getElementsByTagName("td")[0];
                    var thmrmacid = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[1];
                    var thmrdatetimeid = cell.innerHTML;

                    var cell = row.getElementsByTagName("td")[2];
                    var thmrteststandid = cell.innerHTML;                                        

                    thmrqueryDBresult(thmrmodel, thmrmacid, thmrdatetimeid, thmrteststandid);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);        
    }    
}

function addRowHandlers4() 
{   
    var table = document.getElementById("macsearchquerytable");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
		    var cell = row.getElementsByTagName("td")[0];
                    var thmrmodel = cell.innerHTML;                                        

                    var cell = row.getElementsByTagName("td")[1];
                    var thmrmacid = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[2];
                    var thmrdatetimeid = cell.innerHTML;

                    var cell = row.getElementsByTagName("td")[3];
                    var thmrteststandid = cell.innerHTML;  
                                     
                    thmrqueryDBresult(thmrmodel, thmrmacid, thmrdatetimeid, thmrteststandid);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);        
    }          
}

function testsummarybargraph() 
{   
    var model = document.getElementById("tsummodel"), mymodelValue = model.value;  
    var table = document.getElementById("testssumresultsSection");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
		    var cell = row.getElementsByTagName("td")[0];
                    var testname = cell.innerHTML;                                        

                    var cell = row.getElementsByTagName("td")[1];
                    var maximum = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[3];
                    var minimum = cell.innerHTML;

                    var cell = row.getElementsByTagName("td")[4];
                    var puretestname = cell.innerHTML;  

                    testsummarybargraphDBquery(mymodelValue, testname, maximum, minimum, puretestname);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);        
    }           
}

function testsummarybargraphDBquery(mymodelValue, testname, maximum, minimum, puretestname)
{   
    var model = mymodelValue;  
    var testname = testname;
    var maximum = maximum;
    var minimum = minimum;
    var puretestname = puretestname; 
    var xmlhttp;  
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        { 
		var testsummarybargraph=xmlhttp.responseText;
		
            	window.location.assign("individualtestresultsbargraph.php?&model="+model+"&testname="+testname+"&maximum="+maximum+"&minimum="+minimum+"&puretestname="+puretestname );     	         
        }
    }; 
    xmlhttp.open("GET","connection.php?cmd=testsummarybargraphDBquery&model="+model+"&testname="+testname+"&maximum="+maximum+"&minimum="+minimum+
                       "&puretestname="+puretestname, true);   
    xmlhttp.send();    
}

function graphcolumnResults(model, colmin, colmax, testname)
{        
    var model = model; 
    var testname = testname;
    var minimum = colmin;
    var maximum = colmax;    
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            var individualtestresult=xmlhttp.responseText;
            window.location.assign("graphcolumnresults.php?&model=" + model + 
                                    "&testname=" + testname + " &minimum=" + minimum +"&maximum=" + maximum);           
        }
    };    
    xmlhttp.open("GET","connection.php?cmd=graphcolumnresults&model=" + model + 
                                    "&testname=" + testname + " &minimum=" + minimum +"&maximum=" + maximum, true);                      
    xmlhttp.send();  
}

function addRowHandlers5() 
{      
    var table = document.getElementById("graphcolumnresultsTable");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
		    var model = document.getElementById("model"), model = model.value;

		    var testname = document.getElementById("testname"), testname = testname.value;

		    var cell = row.getElementsByTagName("td")[0];
                    var mac = cell.innerHTML;                                        
		    
                    var cell = row.getElementsByTagName("td")[1];
                    var testdatetime = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[2];
                    var teststand = cell.innerHTML;

                    thmrqueryDBresult(model, mac, testdatetime, teststand);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);        
    } 
    
}

function modeldatetimequery2()
{
    document.getElementById("queryrunninglabel").style.display = "block";
    document.getElementById("queryrunninglabel").style.visibility= "visible"; 
    var selectedModel = document.getElementById("msdtmodel").value;
    var startdatetime = document.getElementById("msdtstartdate").value;
    var enddatetime = document.getElementById("msdtenddatetime").value;
    var xmlhttp;      
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
	    	document.getElementById("queryrunninglabel").style.display = "none";
            document.getElementById("queryrunninglabel").style.visibility= "hidden";             
            document.getElementById("dtmresultstable2").innerHTML=xmlhttp.responseText; 
        }
    };
    if(document.getElementById('distinct').checked) 
    {
		var macs = document.getElementById("distinct").value;
	  	xmlhttp.open("GET","connection.php?cmd=modeldatetimequery2&model="+selectedModel+
	                    "&startdatetime="+startdatetime+"&enddatetime="+enddatetime+"&macs="+macs, true);
    }
    else if(document.getElementById('all').checked) 
    {
		var macs = document.getElementById("all").value;
	  	xmlhttp.open("GET","connection.php?cmd=modeldatetimequery2&model="+selectedModel+
	                    "&startdatetime="+startdatetime+"&enddatetime="+enddatetime+"&macs="+macs, true);
    }   
    xmlhttp.send();      
}

function addRowHandlers6() 
{
    var table = document.getElementById("dtmresultstable2");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
                    var model = document.getElementById("msdtmodel"), model = model.value;
                    //var mymodelValue = cell.innerHTML;                                         

                    var cell = row.getElementsByTagName("td")[0];
                    var thmrmacid = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[1];
                    var thmrdatetimeid = cell.innerHTML;                                      
                    
                    thmrqueryDBresult(model, thmrmacid, thmrdatetimeid);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);          
    }    
}

function sonsearchquery(teststr)
{   
    var son = teststr;
    var xmlhttp;  
    
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {            
            document.getElementById("sonsearchquerytable").innerHTML=xmlhttp.responseText;            
        }
    };   
    xmlhttp.open("GET","connection.php?cmd=sonsearchquery&son="+son, true);    
    xmlhttp.send();    
}

function addRowHandlers7() 
{   
    var table = document.getElementById("sonsearchquerytable");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) 
    {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() 
                {
                    var cell = row.getElementsByTagName("td")[0];
                    var son = cell.innerHTML;                                   

                    var cell = row.getElementsByTagName("td")[1];
                    var tdt = cell.innerHTML;                                     

                    var cell = row.getElementsByTagName("td")[2];
                    var mac = cell.innerHTML;  

                    var cell = row.getElementsByTagName("td")[3];
                    var model = cell.innerHTML;    
                    sonqueryDBresult(son, tdt, mac, model);                    
                };
            };
        currentRow.onclick = createClickHandler(currentRow);        
    }          
}

function sonqueryDBresult(son, tdt, mac, model)
{ 	
    var son = son; 
    var tdt = tdt;
	var mac = mac; 
    var model = model;
    //window.alert('Mac: ' + mac + "  Testdatetime: " + tdt + "  Son: " + son + " Model: " + model);
    var xmlhttp;      
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            window.location.assign("sonresults.php?&son=" + son + " &tdt=" + tdt + " &mac=" + mac + " &model=" + model);          
        }
    }; 
    xmlhttp.open("GET","connection.php?cmd=sonresults&son="+son + "&tdt=" + tdt + "&mac=" + mac + "&model=" + model, true);  
    xmlhttp.send();   
}

function addCellHandlers4(thisCell) 
{    
    var initSON = document.getElementById("son");
    var son = initSON.options[initSON.selectedIndex].text;

    var initTDT = document.getElementById("tdt");
    var tdt = initTDT.options[initTDT.selectedIndex].text;

    var initMAC = document.getElementById("mac");
    var mac = initMAC.options[initMAC.selectedIndex].text;

    var model = document.getElementById("model"), mymodel = model.value;

    var cell = thisCell.getElementsByTagName("input");
    var testname = cell[1].getAttribute("value");   

    var tablename = mymodel; 
    individualtest4(son, tdt, mac, testname, mymodel, tablename); 
}

function addCellHandlers4SC(thisCell) 
{    
    var initSON = document.getElementById("son");
    var son = initSON.options[initSON.selectedIndex].text;

    var initTDT = document.getElementById("tdt");
    var tdt = initTDT.options[initTDT.selectedIndex].text;

    var initMAC = document.getElementById("mac");
    var mac = initMAC.options[initMAC.selectedIndex].text;

    var model = document.getElementById("model"), mymodel = model.value;

    var cell = thisCell.getElementsByTagName("input");
    var testname = cell[1].getAttribute("value"); 

    var tablename = mymodel + "__" + testname;
    tablename = tablename.replace('__status', '');
    individualtest4(son, tdt, mac, testname, mymodel, tablename); 
}

function individualtest4(son, tdt, mac, testname, mymodel, tablename)
{    
    var son = son; 
    var tdt = tdt;
    var tstand = tstand
    var testname = testname; 
    var model = mymodel; 
    var tablename = tablename;
    var xmlhttp; 
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {     
            var individualtest=xmlhttp.responseText;
            window.location.assign("individualSON.php?&son=" + son + " &tdt=" + tdt + "&mac="+ mac + " &tname=" + testname + "&model=" + model  + "&tablename=" + tablename);            
        } 
    };    
    xmlhttp.open("GET","connection.php?cmd=individualSONDB&son=" + son + " &tdt=" + tdt + "&mac="+ mac + " &tname=" + testname + " &model=" + model  + "&tablename=" + tablename, true);                        
    xmlhttp.send();  

}

function addCellHandlers5(thisCell) 
{    
    var initSON = document.getElementById("son");
    var son = initSON.options[initSON.selectedIndex].text;
    var initTDT = document.getElementById("tdt");
    var tdt = initTDT.options[initTDT.selectedIndex].text;
    var initMAC = document.getElementById("mac");
    var mac = initMAC.options[initMAC.selectedIndex].text;
    var cell = thisCell.getElementsByTagName("input");
    var testname = cell[1].getAttribute("value");
    var model = document.getElementById("model"), mymodel = model.value;
    var tablename = document.getElementById("tablename"), mytablename = tablename.value;
    individualSONresult4(son, tdt, mac, testname, mymodel, mytablename); 
}

function individualSONresult4(son, tdt, mac, testname, mymodel, mytablename)
{    
    var son = son; 
    var tdt = tdt;
    var mac = mac
    var testname = testname; 
    var model = mymodel;
    var tablename = mytablename;
    var xmlhttp; 
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {     
            var individualtest=xmlhttp.responseText;
            //window.alert('Mac: ' + mac + "  Testdatetime: " + tdt + "  Son: " + son + "  Model: " + mymodel + "  Testname: " + testname + "  tablename: " + mytablename);
            window.location.assign("individualSONresult.php?&son=" + son + " &tdt=" + tdt + "&mac="+ mac + " &tname=" + testname + " &model=" + model + " &tablename=" + tablename);            
        } 
    };    
    xmlhttp.open("GET","connection.php?cmd=individualSONresultDB&son=" + son + " &tdt=" + tdt + "&mac="+ mac + " &tname=" + testname + " &model=" + model + " &tablename=" + tablename, true);                        
    xmlhttp.send(); 
}

function addCellHandlersSpecTables(thisCell) 
{     
    var model = document.getElementById("model"), mymodel = model.value;
    var mac = document.getElementById("mac"), mymac = mac.value;
    var datetime = document.getElementById("datetimestatus");
    var mydatetimestatus = datetime.options[datetime.selectedIndex].text;
    var cell = thisCell.getElementsByTagName("input");
    var mytablenameValue = cell[1].getAttribute("value");
    specialTableresult(mymodel, mymac, mydatetimestatus, mytablenameValue); 
}

function specialTableresult(mymodel, mymac, mydatetimestatus, mytablenameValue)
{    
    var model = mymodel;
    var mac   = mymac;
    var datetimestatus   = mydatetimestatus;
    var tableName   = mytablenameValue;
    var tableName = tableName.replace('__status', '');
    var xmlhttp; 
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {     
            var individualspecttableresults=xmlhttp.responseText;
            window.location.assign("individualspecttableresults.php?&model=" + model + " &mac=" + mac + "&datetimestatus="+ datetimestatus + " &tableName=" + tableName);           
        } 
    };    
    xmlhttp.open("GET","connection.php?cmd=individualspecttableresultsDB&model=" + model + " &mac=" + mac + "&datetimestatus="+ datetimestatus + " &tableName=" + tableName, true);                        
    xmlhttp.send(); 
}

function addCellHandlersSpecTests(thisCell) 
{     
    var model = document.getElementById("model"), mymodel = model.value;
    var mac = document.getElementById("mac"), mymac = mac.value;
    var datetime = document.getElementById("testdatetime");
    var mydatetime = datetime.options[datetime.selectedIndex].text;
    var cell = thisCell.getElementsByTagName("input");
    var test = cell[1].getAttribute("value");
    var testsuite = document.getElementById("testsuite");
    var mytestsuite = testsuite.options[testsuite.selectedIndex].text;
    SpecTestsresults(mymodel, mymac, mydatetime, test, mytestsuite); 
}

function SpecTestsresults(mymodel, mymac, mydatetime, test, mytestsuite)
{    
    var model = mymodel;
    var mac   = mymac;
    var datetime   = mydatetime;
    var testname   = test; 
    var testsuite = mytestsuite;
    var xmlhttp; 
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {     
            var individualspecttestresult=xmlhttp.responseText;
            window.location.assign("individualspecttestresult.php?&model=" + model + " &mac=" + mac + "&datetime="+ datetime + " &testsuite=" + testsuite + " &testname=" + testname);           
        } 
    };  
    xmlhttp.open("GET","connection.php?cmd=individualspecttestresultDB&model=" + model + " &mac=" + mac + "&datetime="+ datetime + " &testsuite=" + testsuite + " &testname=" + testname, true);                        
    xmlhttp.send(); 
}

function esp32actuals(msdtmodel) 
{ 
    var selectedModel = document.getElementById("msdtmodel");
    var selectedModel = selectedModel.options[selectedModel.selectedIndex].text;
    var selectedModel = selectedModel.replace("-", "_");
    var selectedModel = selectedModel.replace(" ", "_");
    var xmlhttp;    
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {    
            //document.getElementById("exportbtn").style.visibility = "visible";         
            document.getElementById("modelresultstable").innerHTML=xmlhttp.responseText;             
        }
    }; 
    //window.alert(selectedModel);
    xmlhttp.open("GET","connection.php?cmd=esp32actuals&model="+selectedModel, true);
    xmlhttp.send();  
}

function exportresults()
{ 
    // This function grabs the model from the ESP32 Actuals page and passes it 
    // the exportesp32value.php file enabling that page to execute the query
    // and allow users to save the file.   
    var selectedModel = document.getElementById("msdtmodel");
    var selectedModel = selectedModel.options[selectedModel.selectedIndex].text;
    var selectedModel = selectedModel.replace("-", "_");
    var selectedModel = selectedModel.replace(" ", "_");
    var xmlhttp;  
    window.location="exportesp32valie.php";  
}

function columnrsquery()
{   
    var selectedModel = document.getElementById("msdtmodel");
    var selectedModel = selectedModel.options[selectedModel.selectedIndex].text;
    var selectedModel = selectedModel.replace("-", "_");
    var selectedModel = selectedModel.replace(" ", "_");
    var xmlhttp;    
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {    
            //document.getElementById("exportbtn").style.visibility = "visible";       
            document.getElementById("columnresultstable").innerHTML=xmlhttp.responseText;             
        }
    }; 
    //window.alert(selectedModel);  
    xmlhttp.open("GET","connection.php?cmd=columnsquery&model="+selectedModel, true);
    xmlhttp.send();  
}

function mactestfails()
{   
    document.getElementById("queryrunninglabel").style.display = "block";
    document.getElementById("queryrunninglabel").style.visibility= "visible"; 
    var selectedModel = document.getElementById("msdtmodel").value;
    var startdatetime = document.getElementById("msdtstartdate").value;
    var enddatetime = document.getElementById("msdtenddatetime").value;
    var xmlhttp;    
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
            document.getElementById("queryrunninglabel").style.display = "none";
            document.getElementById("queryrunninglabel").style.visibility= "hidden";             
            document.getElementById("mactestfailsresultstable").innerHTML=xmlhttp.responseText; 
        }
    };
    if(document.getElementById('distinct').checked) 
    {
        var macs = document.getElementById("distinct").value;
        xmlhttp.open("GET","connection.php?cmd=mactestfails&model="+selectedModel+
                        "&startdatetime="+startdatetime+"&enddatetime="+enddatetime+"&macs="+macs, true);
    }
    else if(document.getElementById('all').checked) 
    {
        var macs = document.getElementById("all").value;
        xmlhttp.open("GET","connection.php?cmd=mactestfails&model="+selectedModel+
                        "&startdatetime="+startdatetime+"&enddatetime="+enddatetime+"&macs="+macs, true);
    }   
    xmlhttp.send();      
}
function addCellHandlers10(thisCell) 
{ 
    var model = document.getElementById("model"), mymodelValue = model.value;                                        
    var mac = document.getElementById("mac"), mymacValue = mac.value;
    var datetime = document.getElementById("datetime"), mydatetimeValue = datetime.value;
    var cell = thisCell.getElementsByTagName("input");
    var tablename = cell[1].getAttribute("value");   
    individualtableresult1(mymodelValue, mymacValue, mydatetimeValue, tablename);     
}
function individualtableresult1(mymodelValue, mymacValue, mydatetimeValue, tablename)
{    
    var itrmodel = mymodelValue; 
    var itrmac = mymacValue;
    var itrdatetime = mydatetimeValue;
    var itrtablename = tablename;
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            var individualtestresult=xmlhttp.responseText;
            window.location.assign("individualtableresults.php?&model=" + itrmodel + 
                                    "&mac=" + itrmac + " &testdatetime=" + itrdatetime +"&tablename=" + itrtablename);           
        }
    };  
    xmlhttp.open("GET","connection.php?cmd=individualtestresultDB&model="+itrmodel+
                       "&mac="+itrmac+"&datetime="+itrdatetime+
                       "&tablename="+itrtablename, true);                      
    xmlhttp.send();
}
function addCellHandlers11(thisCell) 
{ 
    var model = document.getElementById("model"), mymodelValue = model.value;                                        
    var mac = document.getElementById("mac"), mymacValue = mac.value;
    var datetime = document.getElementById("datetime"), mydatetimeValue = datetime.value;
    var cell = thisCell.getElementsByTagName("input");
    var tablename = document.getElementById("tablename").value; 
    var testname = cell[1].getAttribute("value");     
    individualtabletest11(mymodelValue, mymacValue, mydatetimeValue, tablename, testname);     
}
function individualtabletest11(mymodelValue, mymacValue, mydatetimeValue, tablename, testname)
{    
    var itrmodel = mymodelValue; 
    var itrmac = mymacValue;
    var itrdatetime = mydatetimeValue;
    var itrtablename = tablename;
    var itrtestname = testname;
    var xmlhttp;
    if (window.XMLHttpRequest)
    {
      var xmlhttp=new XMLHttpRequest();
    }
    else
    {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {   
            var individualtestresult=xmlhttp.responseText;
            window.location.assign("individualtableTestesults.php?&model=" + itrmodel + 
                                    "&mac=" + itrmac + " &testdatetime=" + itrdatetime +"&tablename=" + itrtablename +"&testname=" + itrtestname);           
        }
    };  
    xmlhttp.open("GET","connection.php?cmd=individualtestresultDB&model="+itrmodel+
                       "&mac="+itrmac+"&datetime="+itrdatetime+
                       "&tablename="+itrtablename, true);                      
    xmlhttp.send();
}

////////////////////////////////////////////////////////////////////////////////

function testFunction()
{
   window.alert("Hello there from TestFunction function!");  
}


 
