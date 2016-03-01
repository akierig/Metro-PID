<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
ini_set('display_errors', false);  
set_exception_handler('returnError');   
?>
<title>Web PIDs (Passenger Information Displays)</title>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<style type="text/css"> 
body {  
  margin: 0;  
  font-size: 24pt;
  font-family: 'Doppio One', verdana, sans-serif;  
  color: #DDFF33;
  background: #000000 -webkit-gradient(linear, left top, left bottom, color-stop(0, rgb(64,64,64)), color-stop(1.00, rgb(0,0,0))) no-repeat;
  background: #000000 -moz-linear-gradient(center top, rgb(64,64,64) 0%, rgb(0,0,0) 100%) no-repeat;
  }
p, th, td {
  font-size: 24pt;
  padding: 1px 8px 0px 8px;
  margin: 1px 8px 0px 8px;
  }
th {
  color: #FFBB33;
  } 
table {
  margin: auto;
  } 
.biglist td {   
  font-size: 12pt;
  line-height: 12pt;
  }
.biglist label:hover {   
  background: #555555;
  }
.direction {
  font-size: 12pt;
  color: #BBBBBB;
  text-align: left;
  }
nav { 
  color: #BBBBBB; 
  text-align: center;
  }
nav a { 
  text-decoration: none;
  }
nav a:hover { 
  text-decoration: underline;
  }
.innerTable td {
  padding: 0px;
  margin: 0px;
  }
.padleft {
  padding-left: 24px;
  } 
.padright {
  padding-right: 24px;
  } 
.banner {  
  color: #FFDD33;
  font-size: 36pt;
  } 
.redline {  
  color: #eb3d2f;
  font-size: 18pt;
  }
.orangeline {  
  color: #ee912d;
  font-size: 18pt;
  }
.yellowline {  
  color: #fee40e;
  font-size: 18pt;
  }
.greenline {  
  color: #10a257;
  font-size: 18pt; 
  }
.blueline {  
  color: #007cbf;
  font-size: 18pt;
  } 
.silverline {  
  color: #9EA9A5;
  font-size: 18pt;
  } 
#clock {  
  color: #FFDD33;
  font-size: 36pt;
  }
</style>
</head>
<?php
$combine = (!is_null($_GET["combine"]));
$stationCode = $_GET["station"];
$stationCodes = explode(",", $_GET["station"]);
?>
<script type="text/javascript">
var xmlhttp;
var combine = <?=(is_null($_GET["combine"]) ? "false" : "true")?>;
var colspan;
if (combine)  
  colspan = 4; 
else  
  colspan = 8; 
var stationCode = "<?=$stationCode?>";
var timer;
var interval = 19000;
track1 = {};
track2 = {};
var topPart;
var PID;
var countdown = 32;
var stations =        {'G03':'Addison Road','F06':'Anacostia','F02':'Archives','C06':'Arlington Cemetery','K04':'Ballston','G01':'Benning Rd','A09':'Bethesda','C12':'Braddock Rd','F11':'Branch Ave','B05':'Brookland','G02':'Capitol Heights','D05':'Capitol South','D11':'Cheverly','K02':'Clarendon','A05':'Cleveland Park','E09':'College Park','E04':'Columbia Heights','F07':'Congress Height','K01':'Court House','C09':'Crystal City','D10':'Deanwood','K07':'Dunn Loring','A03':'Dupont Circle','K05':'East Falls Church','D06':'Eastern Market','C14':'Eisenhower Ave','A02':'Farragut North','C03':'Farragut West','D04':'Federal Center SW','D01':'Federal Triangle','C04':'Foggy Bottom','B09':'Forest Glen','B06,E06':'Fort Totten',                 'J03':'Franconia-Springfield','A08':'Friendship Heights','B01,F01':'Gallery Place',                   'E05':'Georgia Ave','B11':'Glenmont','E10':'Greenbelt','N03':'Greensboro','A11':'Grosvenor','C15':'Huntington','B02':'Judiciary Square','C13':'King St','D03,F03':"L'Enfant Plaza",                 'D12':'Landover','G05':'Largo Town Center','N01':'McLean','C02':'McPherson Square','A10':'Medical Center','A01,C01':'Metro Center',                 'D09':'Minnesota Ave','G04':'Morgan Blvd','E01':'Mount Vernon Square','C10':'National Airport','F05':'Navy Yard','F09':'Naylor Road','D13':'New Carrollton','B35':'New York Ave','C07':'Pentagon','C08':'Pentagon City','D07':'Potomac Ave','E08':'Prince Georges Plaza','B04':'Rhode Island Ave','A14':'Rockville','C05':'Rosslyn','A15':'Shady Grove','E02':'Shaw','B08':'Silver Spring','D02':'Smithsonian','F08':'Southern Ave','N04':'Spring Hill','D08':'Stadium/Armory','F10':'Suitland','B07':'Takoma','A07':'Tenleytown','A13':'Twinbrook','N02':'Tysons Corner','E03':'U Street','B03':'Union Station','J02':'Van Dorn St','A06':'Van Ness UDC','K08':'Vienna','K03':'Virginia Square','K06':'West Falls Church','F04':'Waterfront','E07':'West Hyattsville','B10':'Wheaton','A12':'White Flint','N06':'Wiehle - Reston East','A04':'Woodley Park'};
var stationsPerCode = {'G03':'Addison Road','F06':'Anacostia','F02':'Archives','C06':'Arlington Cemetery','K04':'Ballston','G01':'Benning Rd','A09':'Bethesda','C12':'Braddock Rd','F11':'Branch Ave','B05':'Brookland','G02':'Capitol Heights','D05':'Capitol South','D11':'Cheverly','K02':'Clarendon','A05':'Cleveland Park','E09':'College Park','E04':'Columbia Heights','F07':'Congress Height','K01':'Court House','C09':'Crystal City','D10':'Deanwood','K07':'Dunn Loring','A03':'Dupont Circle','K05':'East Falls Church','D06':'Eastern Market','C14':'Eisenhower Ave','A02':'Farragut North','C03':'Farragut West','D04':'Federal Center SW','D01':'Federal Triangle','C04':'Foggy Bottom','B09':'Forest Glen','B06':'Fort Totten','E06':'Fort Totten','J03':'Franconia-Springfield','A08':'Friendship Heights','B01':'Gallery Place','F01':'Gallery Place','E05':'Georgia Ave','B11':'Glenmont','E10':'Greenbelt','N03':'Greensboro','A11':'Grosvenor','C15':'Huntington','B02':'Judiciary Square','C13':'King St','D03':"L'Enfant Plaza",'F03':"L'Enfant Plaza",'D12':'Landover','G05':'Largo Town Center','N01':'McLean','C02':'McPherson Square','A10':'Medical Center','A01':'Metro Center','C01':'Metro Center','D09':'Minnesota Ave','G04':'Morgan Blvd','E01':'Mount Vernon Square','C10':'National Airport','F05':'Navy Yard','F09':'Naylor Road','D13':'New Carrollton','B35':'New York Ave','C07':'Pentagon','C08':'Pentagon City','D07':'Potomac Ave','E08':'Prince Georges Plaza','B04':'Rhode Island Ave','A14':'Rockville','C05':'Rosslyn','A15':'Shady Grove','E02':'Shaw','B08':'Silver Spring','D02':'Smithsonian','F08':'Southern Ave','N04':'Spring Hill','D08':'Stadium/Armory','F10':'Suitland','B07':'Takoma','A07':'Tenleytown','A13':'Twinbrook','N02':'Tysons Corner','E03':'U Street','B03':'Union Station','J02':'Van Dorn St','A06':'Van Ness UDC','K08':'Vienna','K03':'Virginia Square','K06':'West Falls Church','F04':'Waterfront','E07':'West Hyattsville','B10':'Wheaton','A12':'White Flint','N06':'Wiehle - Reston East','A04':'Woodley Park'};
  assignDirections(["G05","G04","G03","G02","G01"], "Largo", "Vienna and Franconia"); // east end of blue line
  assignDirections(["D13","D12","D11","D10","D09"], "New Carrollton", "Vienna and Franconia"); // east end of orange line
  assignDirections(["D08","D07","D06","D05","D04","D03","D02","D01","C01","C02","C03","C04","C05"], "Largo and New Carrollton (Maryland)", "Vienna and Franconia (Virginia)"); // blue/orange line
  assignDirections(["C06"], "Largo via Washington, DC", "Franconia via National Airport"); // west end of blue line
  assignDirections(["J02","J03"], "Largo via Washington, DC", "Franconia"); // west end of blue line
  assignDirections(["K01","K02","K03","K04","K05","K06","K07","K08"], "New Carrollton via Washington, DC", "Vienna"); // west end of orange line
  assignDirections(["C07","C08","C09"], "Largo and Fort Totten", "Franconia and Huntington via National Airport"); // yellow/blue line
  assignDirections(["C10"], "Largo and Fort Totten via Washington, DC", "Franconia and Huntington"); // yellow/blue line
  assignDirections(["C12","C13"], "Largo and Fort Totten via National Airport", "Franconia and Huntington"); // yellow/blue line
  assignDirections(["F03"], "Greenbelt via Fort Totten", "Branch Ave and Huntington"); // LEnfant Plaza
  assignDirections(["F02","F01","E01","E02","E03","E04","E05"], "Greenbelt via Fort Totten", "Branch Ave and Huntington via L'Enfant Plaza"); // yellow/green line
  assignDirections(["E06","E07","E08","E09","E10"], "Greenbelt", "Branch Ave and Huntington via L'Enfant Plaza"); // green line
  assignDirections(["C15","C14"], "Fort Totten via National Airport", "Huntington"); // south end of yellow line
  assignDirections(["F11","F10","F09","F08","F07","F06","F05","F04"], "Greenbelt", "Branch Ave"); // south end of green line
  assignDirections(["A15","A14","A13","A12","A11","A10","A09"], "Glenmont via Washington, DC", "Shady Grove"); // red line
  assignDirections(["A08","A07","A06","A05","A04","A03","A02"], "Glenmont via Metro Center & Gallery Place", "Shady Grove"); // red line
  assignDirections(["A01"], "Glenmont via Gallery Place", "Shady Grove"); // Metro Center red line
  assignDirections(["B01"], "Glenmont", "Shady Grove via Metro Center"); // Gallery Place red line
  assignDirections(["B02","B03","B35","B04","B05"], "Glenmont via Fort Totten", "Shady Grove via Gallery Place & Metro Center"); // Gallery Place red line
  assignDirections(["B06","B07"], "Glenmont", "Shady Grove via Metro Center"); // Fort Totten & Takoma, red line
  assignDirections(["B08","B09","B10","B11"], "Glenmont", "Shady Grove via Washington, DC"); // Gallery Place red line
  assignDirections(["N01","N02","N03","N04","N06"], "Largo Town Center", "Wiehle-Reston East"); // Silver line

<?php
echo "stationCodes = ['" . $stationCodes[0] . "'";
for ($code = 1; $code < count($stationCodes); $code++) 
  echo ",'" . $stationCodes[$code] . "'";
echo "];\n";
?> 

function clock() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  // var s = today.getSeconds();
  if (h >= 12)  
    ap = "pm"; 
  else
    ap = "am";
  if (h == 0)
    h = 12;
  else if (h > 12) 
    h -= 12;
  return h + ":" + twoDigits(m) + ap;
  }

function twoDigits(i) {
  if (i < 10) 
    return "0" + i;
  return i;
  } 

function getPIDs() {
  if (window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest(); 
    xmlhttp.onreadystatechange = checkPIDs; 
    xmlhttp.open("GET", "http://mvjantzen.com/metro/GetPrediction.php?station=" + stationCode, true);
    xmlhttp.send();
    }
  else
    alert("XMLHttpRequest not available");
  } 

function checkPIDs() { 
  if (xmlhttp.readyState == 4) { 
    if (xmlhttp.status == 200)  { 
      displayPIDs(xmlhttp.responseText);   
      xmlhttp = null; 
      }
    else
      alert("status: " + xmlhttp.status);  
    }
  }  

function assignDirections(codes, dir1, dir2) {
  for (i = 0; i < codes.length; i++) {
    track1[codes[i]] = dir1;
    track2[codes[i]] = dir2;
    }
  }

function displayPIDs(jsonstr) {
  var stations = new Array();  
  var updateTime; 
  trains = JSON.parse(jsonstr).Trains;   
  labels = "Line</th><th>Cars</th><th>Destination</th>"; 
  combine = (document.getElementById('combine').selectedIndex == 0);
  stationName = "";
  first = true; 
  for (code = 0; code < stationCodes.length; code++) {  
    if (stationsPerCode[stationCodes[code]] !== stationName) {
      stationName = stationsPerCode[stationCodes[code]];
      if (first) {
        topPart = "<tr><td colspan=" + colspan + "><table cellpadding=0 cellspacing=0 border=0 width=100% class=innerTable><tr>";
        topPart += "<td align=left class=banner>" + stationName + "&nbsp;&nbsp;&nbsp;</td><td class=banner align=right>";  // add clock later
        first = false;
        PID = "</td>";
        document.title = "Web PIDs: " + stationName;
        }
      else {
        PID += "<tr><td colspan=" + colspan + "><table cellpadding=0 cellspacing=0 border=0 width=100% class=innerTable><tr>";
        PID += "<td align=left class=banner>" + stationName + "&nbsp;&nbsp;&nbsp;</td><td></td>";
        document.title += " & " + stationName;
        }
      PID += "</tr></table></td></tr>";
      }
    if (combine) 
      PID += "<tr><th align=left>" + labels + "<th align=right>Min</th></tr>\n"; 
    else {
      PID += "<tr><th class=direction colspan=4>To " + track1[stationCodes[code]] + "</th><th class='direction padleft' colspan=4>To " + track2[stationCodes[code]] + "</th></tr>\n";
      PID += "<tr><th align=left>" + labels + "<th align=right class=padright>Min</th><th align=left class=padleft>" + labels + "<th align=right>Min</th></tr>\n";
      } 
    group1 = [];
    group2 = [];
    interval = 19000;
    for (i = 0; i < trains.length; i++) {
      if (trains[i].LocationCode == stationCodes[code]) {
        if (trains[i].Min == "1" || trains[i].Min == "ARR" || trains[i].Min == "BRD")
          interval = 12000; // speed it up
        trains[i].Line = trains[i].Line.replace("RD", "Red");
        trains[i].Line = trains[i].Line.replace("OR", "Orange");
        trains[i].Line = trains[i].Line.replace("YL", "Yellow");
        trains[i].Line = trains[i].Line.replace("GR", "Green");
        trains[i].Line = trains[i].Line.replace("BL", "Blue");
        trains[i].Line = trains[i].Line.replace("SV", "Silver");
        trains[i].Line = trains[i].Line.replace("No", "");  
        trains[i].Destination = trains[i].Destination.replace("No Passenger", "<i>no&nbsp;passengers</i>"); 
        trains[i].Destination = trains[i].Destination.replace("Wht Flint", "White&nbsp;Flint"); 
        trains[i].Destination = trains[i].Destination.replace("SilvrSpg", "Silver&nbsp;Spring"); 
        trains[i].Destination = trains[i].Destination.replace("Shady Gr", "Shady&nbsp;Grove");
        trains[i].Destination = trains[i].Destination.replace("Grsvnor", "Grosvenor");
        trains[i].Destination = trains[i].Destination.replace("Grnbelt", "Greenbelt");
        trains[i].Destination = trains[i].Destination.replace("Ft.Tottn", "Fort&nbsp;Totten");
        trains[i].Destination = trains[i].Destination.replace("Hntingtn", "Huntington"); 
        trains[i].Destination = trains[i].Destination.replace("Brnch Av", "Branch&nbsp;Ave"); 
        trains[i].Destination = trains[i].Destination.replace("W Fls Ch", "West&nbsp;Falls&nbsp;Church"); 
        trains[i].Destination = trains[i].Destination.replace("NewCrltn", "New&nbsp;Carrollton"); 
        trains[i].Destination = trains[i].Destination.replace("NEW CARROLLTON", "New&nbsp;Carrollton"); 
        trains[i].Destination = trains[i].Destination.replace("Frnconia", "Franconia"); 
        trains[i].Destination = trains[i].Destination.replace("Mt Vern", "Mt Vernon Sq");   
        trains[i].Destination = trains[i].Destination.replace("VanNess", "Van Ness");   
        trains[i].Destination = trains[i].Destination.replace("Fed Ctr", "Federal Center SW");   
        if (trains[i].Car != null)
          trains[i].Car = trains[i].Car.replace("null", "?");   
        if (trains[i].Group == "2" && !combine)
          info = "<td class=padleft>";
        else
          info = "<td>";
        info += trains[i].Line + "</td><td align=center>" + trains[i].Car + "</td><td>" + trains[i].Destination + "</td><td align=right";
        if (trains[i].Group == "1" && !combine)
          info += " class=padright";
        info += ">" + trains[i].Min + "</td>";
        if (trains[i].Group == "1" || combine)
          group1.push(info);
        else
          group2.push(info); 
        } 
      }  // next i
    most = Math.max(group1.length, group2.length);
    if (most > 0) {
      for (i = 0; i < most; i++) {
        PID += "<tr>";
        if (i < group1.length)
          PID += group1[i];
        else
          PID += "<td></td><td></td><td></td><td></td>";
        if (i < group2.length)
          PID += group2[i];
        else
          PID += "<td></td><td></td><td></td><td></td>";
        PID += "</tr>";
        }
      }  
    else
     PID += "<tr><td colspan=8 align=center><i>No trains scheduled</i></td></tr>";
    } 
  document.getElementById('pids').innerHTML = topPart + clock() + PID; 
  timer = setTimeout("getPIDs()", interval); 
  }   

function clearDisplay() {
  topPart = "<tr><td colspan=" + colspan + "><table cellpadding=0 cellspacing=0 border=0 width=100% class=innerTable><tr>";
  topPart += "<td align=left class=banner>" + stationsPerCode[stationCodes[0]] + "&nbsp;&nbsp;&nbsp;</td><td class=banner align=right>";  // add clock later
  PID = "</tr></table></td></tr>";
  document.getElementById('pids').innerHTML = topPart + clock() + PID; 
  }
  
function newStation(code) {
  clearTimeout(timer);
  stationCodes=[];
  stationCodes[0] = code.substring(0, 3);
  if (code.length > 3)
    stationCodes[1] = code.substring(4, 7);
  stationCode = code;
  clearDisplay();
  getPIDs();
  } 

function newCombineStatus() {
  clearTimeout(timer); 
  clearDisplay();
  getPIDs();
  }
  
function getDisplays() {  
  var param = null;
  var form = document.getElementById('form');
  for (var i = 0; i < form.elements.length; i++ )  
    if (form.elements[i].type == 'checkbox' && form.elements[i].checked == true) {
      if (param == null)
        param = form.elements[i].value;
      else
        param += "," + form.elements[i].value;
      }
  if (param == null)
    alert("Select at least one station");
  else
    window.location = 'pids.php?station=' + param;
  }
//x="";
//for (k in stations)
//  x += "<label for=" + k + "><input type=checkbox value=" + k + " id=" + k + "> " + stations[k] + "</label><br>\n";
//alert(x);
</script>
<?php
if (is_null($_GET["station"])) {
?>
<body> 
&nbsp;
<p>
<form id=form>
<table cellspacing=0 border=0 class=biglist> 
<tr>
<td valign=top>
<label for=G03><input type=checkbox value=G03 id=G03> Addison Road <span class=blueline>●</span><span class=silverline>●</span></label><br>
<label for=F06><input type=checkbox value=F06 id=F06> Anacostia <span class=greenline>●</span></label><br>
<label for=F02><input type=checkbox value=F02 id=F02> Archives <span class=yellowline>●</span><span class=greenline>●</span></label><br>
<label for=C06><input type=checkbox value=C06 id=C06> Arlington Cemetery <span class=blueline>●</span></label><br>
<label for=K04><input type=checkbox value=K04 id=K04> Ballston <span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=G01><input type=checkbox value=G01 id=G01> Benning Rd <span class=blueline>●</span><span class=silverline>●</span></label><br>
<label for=A09><input type=checkbox value=A09 id=A09> Bethesda <span class=redline>●</span></label><br>
<label for=C12><input type=checkbox value=C12 id=C12> Braddock Rd <span class=blueline>●</span><span class=yellowline>●</span></label><br>
<label for=F11><input type=checkbox value=F11 id=F11> Branch Ave <span class=greenline>●</span></label><br>
<label for=B05><input type=checkbox value=B05 id=B05> Brookland <span class=redline>●</span></label><br>
<label for=G02><input type=checkbox value=G02 id=G02> Capitol Heights <span class=blueline>●</span><span class=silverline>●</span></label><br>
<label for=D05><input type=checkbox value=D05 id=D05> Capitol South <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=D11><input type=checkbox value=D11 id=D11> Cheverly <span class=orangeline>●</span></label><br>
<label for=K02><input type=checkbox value=K02 id=K02> Clarendon <span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=A05><input type=checkbox value=A05 id=A05> Cleveland Park <span class=redline>●</span></label><br>
<label for=E09><input type=checkbox value=E09 id=E09> College Park <span class=greenline>●</span></label><br>
<label for=E04><input type=checkbox value=E04 id=E04> Columbia Heights <span class=yellowline>●</span><span class=greenline>●</span></label><br>
<label for=F07><input type=checkbox value=F07 id=F07> Congress Height <span class=greenline>●</span></label><br>
<label for=K01><input type=checkbox value=K01 id=K01> Court House <span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=C09><input type=checkbox value=C09 id=C09> Crystal City <span class=blueline>●</span><span class=yellowline>●</span></label><br>
<label for=D10><input type=checkbox value=D10 id=D10> Deanwood <span class=orangeline>●</span></label><br>
<label for=K07><input type=checkbox value=K07 id=K07> Dunn Loring <span class=orangeline>●</span></label><br>
<label for=A03><input type=checkbox value=A03 id=A03> Dupont Circle <span class=redline>●</span></label><br>
<label for=K05><input type=checkbox value=K05 id=K05> East Falls Church <span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=D06><input type=checkbox value=D06 id=D06> Eastern Market <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=C14><input type=checkbox value=C14 id=C14> Eisenhower Ave <span class=yellowline></label><br>
<label for=A02><input type=checkbox value=A02 id=A02> Farragut North <span class=redline>●</span></label><br>
<label for=C03><input type=checkbox value=C03 id=C03> Farragut West <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=D04><input type=checkbox value=D04 id=D04> Federal Center SW <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=D01><input type=checkbox value=D01 id=D01> Federal Triangle <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=C04><input type=checkbox value=C04 id=C04> Foggy Bottom <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
</td>
<td valign=top>
<label for=B09><input type=checkbox value=B09 id=B09> Forest Glen <span class=redline>●</span></label><br>
<label for=B06><input type=checkbox value="B06,E06" id=B06> Fort Totten <span class=yellowline>●</span><span class=greenline>●</span><span class=redline>●</span></label><br>
<label for=J03><input type=checkbox value=J03 id=J03> Franconia-Springfield <span class=blueline>●</span></label><br>
<label for=A08><input type=checkbox value=A08 id=A08> Friendship Heights</label><br>
<label for=B01><input type=checkbox value="B01,F01" id=B01> Gallery Place <span class=yellowline>●</span><span class=greenline>●</span><span class=redline>●</span></label><br>
<label for=E05><input type=checkbox value=E05 id=E05> Georgia Ave <span class=yellowline>●</span><span class=greenline>●</span></label><br>
<label for=B11><input type=checkbox value=B11 id=B11> Glenmont <span class=redline>●</span></label><br>
<label for=E10><input type=checkbox value=E10 id=E10> Greenbelt <span class=greenline>●</span></label><br>
<label for=N03><input type=checkbox value=N03 id=N03> Greensboro <span class=silverline>●</span></label><br>
<label for=A11><input type=checkbox value=A11 id=A11> Grosvenor <span class=redline>●</span></label><br>
<label for=C15><input type=checkbox value=C15 id=C15> Huntington <span class=yellowline></label><br>
<label for=B02><input type=checkbox value=B02 id=B02> Judiciary Square <span class=redline>●</span></label><br>
<label for=C13><input type=checkbox value=C13 id=C13> King St <span class=blueline>●</span><span class=yellowline>●</span></label><br>
<label for=D03><input type=checkbox value="D03,F03" id=D03> L'Enfant Plaza <span class=blueline>●</span><span class=orangeline>●</span><span class=yellowline>●</span><span class=greenline>●</span><span class=silverline>●</span></label><br>
<label for=D12><input type=checkbox value=D12 id=D12> Landover <span class=orangeline>●</span></label><br>
<label for=G05><input type=checkbox value=G05 id=G05> Largo Town Center <span class=blueline>●</span><span class=silverline>●</span></label><br>
<label for=N01><input type=checkbox value=N01 id=N01> McLean <span class=silverline>●</span></label><br>
<label for=C02><input type=checkbox value=C02 id=C02> McPherson Square <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=A10><input type=checkbox value=A10 id=A10> Medical Center <span class=blueline>●</span><span class=orangeline>●</span></label><br>
<label for=A01><input type=checkbox value="A01,C01" id=A01> Metro Center <span class=orangeline>●</span><span class=blueline>●</span><span class=redline>●</span><span class=silverline>●</span></label><br>
<label for=D09><input type=checkbox value=D09 id=D09> Minnesota Ave <span class=orangeline>●</span></label><br>
<label for=G04><input type=checkbox value=G04 id=G04> Morgan Blvd <span class=blueline>●</span><span class=silverline>●</span></label><br>
<label for=E01><input type=checkbox value=E01 id=E01> Mount Vernon Sq <span class=yellowline>●</span><span class=greenline>●</span></label><br>
<label for=C10><input type=checkbox value=C10 id=C10> National Airport <span class=blueline>●</span><span class=yellowline>●</span></label><br>
<label for=F05><input type=checkbox value=F05 id=F05> Navy Yard <span class=greenline>●</span></label><br>
<label for=F09><input type=checkbox value=F09 id=F09> Naylor Road <span class=greenline>●</span></label><br>
<label for=D13><input type=checkbox value=D13 id=D13> New Carrollton <span class=orangeline>●</span></label><br>
<label for=B35><input type=checkbox value=B35 id=B35> New York Ave <span class=redline>●</span></label><br>
<label for=C07><input type=checkbox value=C07 id=C07> Pentagon <span class=blueline>●</span><span class=yellowline>●</span></label><br>
<label for=C08><input type=checkbox value=C08 id=C08> Pentagon City <span class=blueline>●</span><span class=yellowline>●</span></label><br>
</td>
<td valign=top>
<label for=D07><input type=checkbox value=D07 id=D07> Potomac Ave <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=E08><input type=checkbox value=E08 id=E08> P.G. Plaza <span class=greenline>●</span></label><br>
<label for=B04><input type=checkbox value=B04 id=B04> Rhode Island Ave <span class=redline>●</span></label><br>
<label for=A14><input type=checkbox value=A14 id=A14> Rockville <span class=redline>●</span></label><br>
<label for=C05><input type=checkbox value=C05 id=C05> Rosslyn <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=A15><input type=checkbox value=A15 id=A15> Shady Grove <span class=redline>●</span></label><br>
<label for=E02><input type=checkbox value=E02 id=E02> Shaw <span class=yellowline>●</span><span class=greenline>●</span></label><br>
<label for=B08><input type=checkbox value=B08 id=B08> Silver Spring <span class=redline>●</span></label><br>
<label for=D02><input type=checkbox value=D02 id=D02> Smithsonian <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=F08><input type=checkbox value=F08 id=F08> Southern Ave <span class=greenline>●</span></label><br>
<label for=N04><input type=checkbox value=N04 id=N04> Spring Hill <span class=silverline>●</span></label><br>
<label for=D08><input type=checkbox value=D08 id=D08> Stadium/Armory <span class=blueline>●</span><span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=F10><input type=checkbox value=F10 id=F10> Suitland <span class=greenline>●</span></label><br>
<label for=B07><input type=checkbox value=B07 id=B07> Takoma <span class=redline>●</span></label><br>
<label for=A07><input type=checkbox value=A07 id=A07> Tenleytown <span class=redline>●</span></label><br>
<label for=A13><input type=checkbox value=A13 id=A13> Twinbrook <span class=redline>●</span></label><br>
<label for=N02><input type=checkbox value=N02 id=N02> Tysons Corner <span class=silverline>●</span></label><br>
<label for=E03><input type=checkbox value=E03 id=E03> U Street <span class=yellowline>●</span><span class=greenline>●</span></label><br>
<label for=B03><input type=checkbox value=B03 id=B03> Union Station</label><br>
<label for=J02><input type=checkbox value=J02 id=J02> Van Dorn St <span class=blueline>●</span></label><br>
<label for=A06><input type=checkbox value=A06 id=A06> Van Ness UDC</label><br>
<label for=K08><input type=checkbox value=K08 id=K08> Vienna <span class=orangeline>●</span></label><br>
<label for=K03><input type=checkbox value=K03 id=K03> Virginia Square <span class=orangeline>●</span><span class=silverline>●</span></label><br>
<label for=K06><input type=checkbox value=K06 id=K06> West Falls Church <span class=orangeline>●</span></label><br>
<label for=F04><input type=checkbox value=F04 id=F04> Waterfront <span class=greenline>●</span></label><br>
<label for=E07><input type=checkbox value=E07 id=E07> West Hyattsville <span class=greenline>●</span></label><br>
<label for=B10><input type=checkbox value=B10 id=B10> Wheaton <span class=redline>●</span></label><br>
<label for=A12><input type=checkbox value=A12 id=A12> White Flint <span class=redline>●</span></label><br>
<label for=N06><input type=checkbox value=N06 id=N06> Wiehle - Reston East <span class=silverline>●</span></label><br>
<label for=A04><input type=checkbox value=A04 id=A04> Woodley Park <span class=redline>●</span></label><br>
<nav><input type=button value=" get displays " onclick="getDisplays()"> &nbsp; <a href="http://www.mvjantzen.com/blog/?p=1383" class=direction>About</a></nav> 
</td>
</tr>
</table>
</form>
<?php
  }
else {
$stations = array('G03'=>'Addison Road','F06'=>'Anacostia','F02'=>'Archives','C06'=>'Arlington Cemetery','K04'=>'Ballston','G01'=>'Benning Rd','A09'=>'Bethesda','C12'=>'Braddock Rd','F11'=>'Branch Ave','B05'=>'Brookland','G02'=>'Capitol Heights','D05'=>'Capitol South','D11'=>'Cheverly','K02'=>'Clarendon','A05'=>'Cleveland Park','E09'=>'College Park','E04'=>'Columbia Heights','F07'=>'Congress Height','K01'=>'Court House','C09'=>'Crystal City','D10'=>'Deanwood','K07'=>'Dunn Loring','A03'=>'Dupont Circle','K05'=>'East Falls Church','D06'=>'Eastern Market','C14'=>'Eisenhower Ave','A02'=>'Farragut North','C03'=>'Farragut West','D04'=>'Federal Center SW','D01'=>'Federal Triangle','C04'=>'Foggy Bottom','B09'=>'Forest Glen','B06,E06'=>'Fort Totten','J03'=>'Franconia-Springfield','A08'=>'Friendship Heights','B01,F01'=>'Gallery Place','E05'=>'Georgia Ave','B11'=>'Glenmont','E10'=>'Greenbelt','N03'=>'Greensboro','A11'=>'Grosvenor','C15'=>'Huntington','B02'=>'Judiciary Square','C13'=>'King St','D03,F03'=>"L'Enfant Plaza",'D12'=>'Landover','G05'=>'Largo Town Center',
  'N01'=>'McLean','C02'=>'McPherson Square','A10'=>'Medical Center','A01,C01'=>'Metro Center','D09'=>'Minnesota Ave','G04'=>'Morgan Blvd','E01'=>'Mount Vernon Square','C10'=>'National Airport','F05'=>'Navy Yard','F09'=>'Naylor Road','D13'=>'New Carrollton','B35'=>'New York Ave','C07'=>'Pentagon','C08'=>'Pentagon City','D07'=>'Potomac Ave','E08'=>'Prince Georges Plaza','B04'=>'Rhode Island Ave','A14'=>'Rockville','C05'=>'Rosslyn','A15'=>'Shady Grove','E02'=>'Shaw','B08'=>'Silver Spring','D02'=>'Smithsonian','F08'=>'Southern Ave','N04'=>'Spring Hill','D08'=>'Stadium/Armory','F10'=>'Suitland','B07'=>'Takoma','A07'=>'Tenleytown','A13'=>'Twinbrook','N02'=>'Tysons Corner','E03'=>'U Street','B03'=>'Union Station','J02'=>'Van Dorn St','A06'=>'Van Ness UDC','K08'=>'Vienna','K03'=>'Virginia Square','K06'=>'West Falls Church','F04'=>'Waterfront','E07'=>'West Hyattsville','B10'=>'Wheaton','A12'=>'White Flint','N06'=>'Wiehle - Reston East ','A04'=>'Woodley Park');
$dropDown = ""; 
foreach ($stations as $k => $v) {
  $dropDown .= "<option value=" . $k;
  if (strpos($k, $stationCodes[0]) !== false) 
    $dropDown .= " selected"; 
  $dropDown .= ">" . $v . "</option>";
  }
?>
<body onload="clearDisplay();getPIDs();"> 
<table cellspacing=0 border=0 id=pids> 
</table>
<p align=center>
<nav>
<a href="pids.php" class=direction>Home</a> 
<select id=selectStation onchange="newStation(this.value)">
  <?=$dropDown?>
  </select>
<select id=combine onchange="newCombineStatus()">
  <option <?=($combine ? "selected" : "")?> >Combine tracks</option>
  <option <?=($combine ? "" : "selected")?> >Separate tracks</option>
  </select>
<a href="http://www.mvjantzen.com/blog/?p=1383" class=direction>About</a> 
</nav> 
<?php
  } 
?>
</body>
</html>