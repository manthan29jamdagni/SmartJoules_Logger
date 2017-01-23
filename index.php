<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
<script src="js/script_index.js"></script>
</head>
<body>
<?php 
 //$xml = simplexml_load_file("/var/www/html/configuration.xml") or die("Error: Cannot open configuration file");
 $xml = simplexml_load_file("configuration2.xml") or die("Error: Cannot open configuration file");
 $varURL = $xml->URL;
 $varKey = $xml->KEY;
 $var = $xml->modbus->children(); 
 $tags = array();
for($i=0;$i<count($var)-1;$i=$i+2)
{
	$mdMapcount="mdMAP".($i+1);
	$tempMDMAP=json_decode(json_encode($var[$i]->$mdMapcount),TRUE);
	$tempSTR=json_decode(json_encode($var[$i+1]->STR),TRUE);
	$tempSID=json_decode(json_encode($var[$i+1]->SID),TRUE);
	$tempDID=json_decode(json_encode($var[$i+1]->DID),TRUE);
	$tempTYP=json_decode(json_encode($var[$i+1]->TYP),TRUE);
	$tempJIO=json_decode(json_encode($var[$i+1]->JIO),TRUE);	
	$arrayTemp=array();
	array_push($arrayTemp, $tempSTR,$tempSID,$tempDID,$tempTYP,$tempJIO);	
	array_push($tags,$arrayTemp);	
}
 $varChiller = $xml->chillerWebControl;
 $varVFD = $xml->vfdWebControl;
 $varJouleIO = $xml->jouleIOWebControl;
?>

<nav>
    <div class="nav-wrapper blue">
      <a href="#" class="brand-logo center">Smart Joules Data Logger v.1.1</a>
    </div>
</nav>
<div class="card">
<div class="grey-text text-darken-1" align="center">
	<p><h5>Configuration Page</h5></p>	
</div>
<p>
<form method="post">
	Uploading URL<br>
	<input type="hidden" id="count_click" name="count_click" value="<?php $temp=$xml->modbus->children(); if(count($tags)==0) echo "1"; else echo count($tags); ?>"/>
	<input type="text" name="uploadingURL"  <?php echo 'value ="'.$varURL.'"' ?> disabled>
	<br>
	<br>
	Security Key<br>
	<input type="text" name="securityKey"  <?php echo 'value ="'.$varKey.'"' ?> disabled>
	<br>
	<h5>Enter Slave Ids, DIDs and Type of Modbus Devices</h5>
	<b>Warning:</b> Leaving fields blank will translate into SID=0 or DID = 0 and data will not be uploaded for those  devices.
	<br/>
	<br/>

	<table class="highlight" id="dynamic">
	<?php
  	$temp=$xml->modbus->children();

	if(count($tags)==0)
	{		
				echo "<tr>
    <td><b>Device 1</b></td>
    <td><input type='text' name='str1' 'value =''></td>
    <td>SID:</td>
    <td><input id='sid' type='text' name='sid1' 'value =''></td>
    <td>DID:</td>
    <td><input id='did' type='text' name='did1' 'value =''></td>
    <td>Type:</td>
    <td>
    	<select class='browser-default' name='typ1' data_val='1'>
			<option value='NF29'>NF29</option><option value='Chiller'>Chiller</option><option value='VFD'>VFD</option><option value='EN8400'>EN8400</option><option value='JouleIO'>JouleIO</option>
		</select>
	</td>
	<td>
		<button class='btn' id='deletebtn0' onclick=\"event.preventDefault();deleteEntry('0');\">Delete</button>
	</td>
  </tr>";
	}
	else
	{
		for($i=0;$i<count($tags);$i++)
		{	
			$htmString="<tr>
    <td><b>Device ".($i+1)."</b></td>
    <td><input type='text' name='str".($i+1)."' value ='".$tags[$i][0][0]."'></td>
    <td>SID:</td>
    <td><input type='text' name='sid".($i+1)."' value ='".$tags[$i][1][0]."'></td>
    <td>DID:</td>
    <td><input type='text' name='did".($i+1)."' value ='".$tags[$i][2][0]."'></td>
    <td>Type:</td>
    <td><select class='browser-default' name='typ".($i+1)."' data_val=$i>";
    $options="";
    	if($tags[$i][3][0]=="NF29")
    	{
		$options="<option value='NF29' selected>NF29</option><option value='Chiller'>Chiller</option><option value='VFD'>VFD</option><option value='EN8400'>EN8400</option><option id='jio' value='JouleIO'>JouleIO</option>";
    	}
    	if($tags[$i][3][0]=="Chiller")
    	{
		$options="<option value='NF29'>NF29</option><option value='Chiller' selected>Chiller</option><option value='VFD'>VFD</option><option value='EN8400'>EN8400</option><option id='jio' value='JouleIO'>JouleIO</option>";
    	}
    	if($tags[$i][3][0]=="VFD")
    	{
		$options="<option value='NF29'>NF29</option><option value='Chiller'>Chiller</option><option value='VFD' selected>VFD</option><option value='EN8400'>EN8400</option><option id='jio' value='JouleIO'>JouleIO</option>";
    	}
    	if($tags[$i][3][0]=="EN8400")
    	{
    		
		$options="<option value='NF29'>NF29</option><option value='Chiller'>Chiller</option><option value='VFD'>VFD</option><option value='EN8400' selected>EN8400</option><option id='jio' value='JouleIO'>JouleIO</option>";
    	}
    	if($tags[$i][3][0]=="JouleIO")
    	{
		$options="<option value='NF29'>NF29</option><option value='Chiller'>Chiller</option><option value='VFD'>VFD</option><option value='EN8400'>EN8400</option><option id='jio' value='JouleIO' selected>JouleIO</option>";
    	}
    	
    	
echo $htmString;
echo $options;
$id = $i+1;
echo "	</select></td>
		<td>
			<button class='btn' id='deletebtn$id' onclick=\"event.preventDefault();deleteEntry('$id');\">Delete</button>
		</td>
		</tr>";
		}
		
	}
	?>
  	</table>
<input type="hidden" name="xml_str" id="xml_str" value="1"/>
	<br>
  <input type="checkbox" name="chillerControl" id="chillerControl" <?php echo ($varChiller == 1 ? 'checked' : '' ); ?>>
  <label for="chillerControl">Chiller Control</label>
  <br>
  <input type="checkbox" name="vfdControl" id="vfdControl" <?php echo ($varVFD == 1 ? 'checked' : '' ); ?>>
  <label for="vfdControl">VFD Control</label>
  <br>
  <input type="checkbox" name="jouleIOControl" id="jouleIOControl" <?php echo ($varJouleIO == 1 ? 'checked' : '' ); ?>>
  <label for="jouleIOControl">Joule IO Control</label>
  <br>
<form>
	<center>
	<button class="btn" name="add" id="add">Add More</button>
	<button class="btn" name="submit" id="submit">Submit</button></center>
</form>
</p>
</div>
</body>
</html>

<?php 
	if(isset($_POST['submit'])) {
		$myFileRead = new DOMDocument();
		$myFileRead->preserveWhiteSpace = false;
		$myFileRead->formatOutput = true;
		$myFileRead->load('configuration2.xml');	
		$xmlstr=$_POST['xml_str'];			
	  	$delim1 = explode(";", $xmlstr);  
		$xmlstr=$_POST['xml_str'];			
	  	$delim1 = explode(";", $xmlstr);
	  	$elementOld = $myFileRead->getElementsByTagName("modbus")[0];
	  	$element=$myFileRead->createElement("modbus");
	  	$prevSID='';
	  	$prevType='';
	  	$c=1;
	  	for($i=0;$i<count($tags);$i++)
	  	{			
	  				$el="md".($i+1);
	  				$delim2 = explode("|", $delim1[$i]);
	  				if($delim2[1]=='0' || $delim2[2]=='0') //warning condition if field is empty dont save.
	  				{
	  					continue;
	  				}
					$mdMAP=$myFileRead->createElement("mdMAP".($i+1));
					if($prevSID==$delim2[1] && $prevType==$delim2[3] && $prevType=='JouleIO')
					{
						$c++;	
					}
					else
					{
						$c=1;
					}
					$mdMAP->appendChild($myFileRead->createTextNode($c));

					$str=$myFileRead->createElement("STR");
					$str->appendChild($myFileRead->createTextNode($delim2[0]));

					$sid=$myFileRead->createElement("SID");
					$sid->appendChild($myFileRead->createTextNode($delim2[1]));

					$did=$myFileRead->createElement("DID");
					$did->appendChild($myFileRead->createTextNode($delim2[2]));

					$typ=$myFileRead->createElement("TYP");
					$typ->appendChild($myFileRead->createTextNode($delim2[3]));

					$ji=$myFileRead->createElement("JIO");

					$prevSID=$delim2[1];
	  				$prevType=$delim2[3];
					
					$signal=$myFileRead->createElement("SIGNAL");
					$signal->appendChild($myFileRead->createTextNode($tags[$i][4]["SIGNAL"]));
					$io=$myFileRead->createElement("IO");
					$io->appendChild($myFileRead->createTextNode($tags[$i][4]["IO"]));
					$port=$myFileRead->createElement("PORT");
					$port->appendChild($myFileRead->createTextNode($tags[$i][4]["PORT"]));
					$count=$myFileRead->createElement("COUNT");
					$count->appendChild($myFileRead->createTextNode($tags[$i][4]["COUNT"]));
					$min=$myFileRead->createElement("MIN");
					$min->appendChild($myFileRead->createTextNode($tags[$i][4]["MIN"]));
					$max=$myFileRead->createElement("MAX");
					$max->appendChild($myFileRead->createTextNode($tags[$i][4]["MAX"]));
					$pid=$myFileRead->createElement("PID");
					$pid->appendChild($myFileRead->createTextNode($tags[$i][4]["PID"]));
					$type=$myFileRead->createElement("TYPE");
					$type->appendChild($myFileRead->createTextNode($tags[$i][4]["TYPE"]));
					$wire=$myFileRead->createElement("WIRE");
					$wire->appendChild($myFileRead->createTextNode($tags[$i][4]["WIRE"]));
					
					$ji->appendChild($signal);
					$ji->appendChild($io);
					$ji->appendChild($port);
					$ji->appendChild($count);
					$ji->appendChild($min);
					$ji->appendChild($max);
					$ji->appendChild($pid);
					$ji->appendChild($type);
					$ji->appendChild($wire);

					//null jios
					
					$md=$myFileRead->createElement($el);
					$md->appendChild($str);
					$md->appendChild($sid);
					$md->appendChild($did);
					$md->appendChild($typ);
					$md->appendChild($ji);
						
					$element->appendChild($mdMAP);	
					$element->appendChild($md);

	  	}

			for($j=count($tags);$j<count($tags)+($_POST['count_click']-count($tags));$j++)
			{	
					$el="md".($j+1);
	  				$delim2 = explode("|", $delim1[$j]);
	  				echo "<script>console.log('$delim2[1]')</script>";
	  				if($delim2[1]=='0' || $delim2[2]=='0') //warning condition if field is empty dont save.
	  				{
	  					continue;
	  				}
	  				$mdMAP=$myFileRead->createElement("mdMAP".($j+1));
	  				$c=1;
					$mdMAP->appendChild($myFileRead->createTextNode($c));

					$str=$myFileRead->createElement("STR");
					$str->appendChild($myFileRead->createTextNode($delim2[0]));

					$sid=$myFileRead->createElement("SID");
					$sid->appendChild($myFileRead->createTextNode($delim2[1]));

					$did=$myFileRead->createElement("DID");
					$did->appendChild($myFileRead->createTextNode($delim2[2]));

					$typ=$myFileRead->createElement("TYP");
					$typ->appendChild($myFileRead->createTextNode($delim2[3]));

					$ji=$myFileRead->createElement("JIO");
					
					$signal=$myFileRead->createElement("SIGNAL");
					$signal->appendChild($myFileRead->createTextNode("null"));
					$io=$myFileRead->createElement("IO");
					$io->appendChild($myFileRead->createTextNode("null"));
					$port=$myFileRead->createElement("PORT");
					$port->appendChild($myFileRead->createTextNode("null"));
					$count=$myFileRead->createElement("COUNT");
					$count->appendChild($myFileRead->createTextNode("null"));
					$min=$myFileRead->createElement("MIN");
					$min->appendChild($myFileRead->createTextNode("null"));
					$max=$myFileRead->createElement("MAX");
					$max->appendChild($myFileRead->createTextNode("null"));
					$pid=$myFileRead->createElement("PID");
					$pid->appendChild($myFileRead->createTextNode("null"));
					$type=$myFileRead->createElement("TYPE");
					$type->appendChild($myFileRead->createTextNode("null"));
					$wire=$myFileRead->createElement("WIRE");
					$wire->appendChild($myFileRead->createTextNode("null"));
					
					$ji->appendChild($signal);
					$ji->appendChild($io);
					$ji->appendChild($port);
					$ji->appendChild($count);
					$ji->appendChild($min);
					$ji->appendChild($max);
					$ji->appendChild($pid);
					$ji->appendChild($type);
					$ji->appendChild($wire);

					//null jios
					
					$md=$myFileRead->createElement($el);
					$md->appendChild($str);
					$md->appendChild($sid);
					$md->appendChild($did);
					$md->appendChild($typ);
					$md->appendChild($ji);
						
					$element->appendChild($mdMAP);	
					$element->appendChild($md);
			}


									$chillerWebControlOld=$myFileRead->getElementsByTagName("chillerWebControl")[0];
									$vfdWebControlOld=$myFileRead->getElementsByTagName("vfdWebControl")[0];
									$jouleIOWebControlOld=$myFileRead->getElementsByTagName("jouleIOWebControl")[0];


									$chillerWebControl=$myFileRead->createElement("chillerWebControl");
									if (isset($_POST['chillerControl'])) 
									$chillerWebControl->appendChild($myFileRead->createTextNode("1"));
									else
										$chillerWebControl->appendChild($myFileRead->createTextNode("0"));	
									$vfdWebControl=$myFileRead->createElement("vfdWebControl");
									if (isset($_POST['vfdControl'])) 
									$vfdWebControl->appendChild($myFileRead->createTextNode("1"));
									else
										$vfdWebControl->appendChild($myFileRead->createTextNode("0"));

									$jouleIOWebControl=$myFileRead->createElement("jouleIOWebControl");
									if (isset($_POST['jouleIOControl'])) 
									$jouleIOWebControl->appendChild($myFileRead->createTextNode("1"));
									else
										$jouleIOWebControl->appendChild($myFileRead->createTextNode("0"));

									$chillerWebControlOld->parentNode->replaceChild($chillerWebControl, $chillerWebControlOld);
									$vfdWebControlOld->parentNode->replaceChild($vfdWebControl, $vfdWebControlOld);
									$jouleIOWebControlOld->parentNode->replaceChild($jouleIOWebControl, $jouleIOWebControlOld);


									$elementOld->parentNode->replaceChild($element, $elementOld);

		$myFileRead->save("configuration2.xml");
		echo "<script>window.location='index.php'</script>";
	}
	?> 