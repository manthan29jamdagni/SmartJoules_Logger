<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/script_Joule.js"></script>
<style type="text/css">
table,td{
	border: groove 1px #eee;
}
</style>
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
	// $array_temp=json_encode($arrayTemp,TRUE);	
	array_push($tags,$arrayTemp);
	
}

 $varChiller = $xml->chillerWebControl;
 $varVFD = $xml->vfdWebControl;
 $varJouleIO = $xml->jouleIOWebControl;

?>
<input type="hidden" name="a" id="deviceId" value='<?php 
	echo $_GET['data'];
// echo "<span><b>Joule IO Configuration for Device".$_GET['data']."</b></span> <br>";
$str="
<div class='card'
<table>
	<tr>
		<td>
		<b>Name</b>
		</td>
		<td>
		<input type='text' name='name1' value=''>
		</td>
	</tr>

	<tr>
		
				<td>	
				<p>			
				<input type='radio' id='signalType1' name='signalType1' value='Analog'>
				<label for='signalType1'>Analog</label>
				</p><p>
				<input type='radio' id='signalType2' name='signalType1' value='Digital'>
				<label for='signalType2'>Digital</label>
				</p>
				</td>
				<td>
				<p>
				<input type='radio' id='inputType1' name='inputType1' value='Input'>
				<label for='inputType1'>Input</label>
				</p><p>
				<input type='radio' id='inputType1' name='inputType2' value='Output'>
				<label for='inputType2'>Output</label>
				</p>
				</td>
				<td>
					<table>
					<tr>
					<td><b>Port No : </b></td> <td> <input type='text' name='portNo1' value=''></td>
					</tr>
					<tr>
					<td><b>Port Count : </b></td><td><input type='text' name='portCount1' value=''></td>
					</tr>
					</table>
				</td>
				<td>
				<table>
					<tr>
					<td><b>Range Min : </b></td><td> <input type='text' name='min1' value=''></td>
					</tr>
					<tr>
					<td><b>Range Max : </b></td> <td><input type='text' name='max1' value=''></td>
					</tr>
				</table>
				</td>

				<td>
				<table>
					<tr>
					<td><b>DID : </b></td><td> <input type='text' name='did1' value=''></td>
					</tr>
					<tr>
					<td><b>PID : </b></td> <td><input type='text' name='pid1' value=''></td>
					</tr>
				</table>
				</td>
				
	</tr>		
	<tr>
		<td><b>Type</b></td>
		<td>
		<select class='browser-default' name='in_type1'>
		  <option value='input1'>input1</option>
		  <option value='input2'>input2</option>
		  <option value='input3'>input3</option>
		</select>
		</td>
		<td>

			 <input type='checkbox' id='singleWires1' name='singleWires1'>
			 <label for='singleWires1'>Single Wires</label>
		</td>
	</tr>
</table>
</div>
	";

?>' /> 

<form  method="post">
<nav>
	<div class="nav-wrapper blue">
      <a class="brand-logo center">Joule IO Configuration for SID : <?php echo $_GET["sid"]; ?></a>
    </div>
</nav>
<div name='dynamic' id="dynamic">
<input type="hidden" name="count_click" id="count_click" value="1"/>
<?php
	echo "
<div class='card'>
<table>
	<tr>
		<td>
		<b>Name</b>
		</td>
		<td>
		<input type='text' name='name1' value='".$tags[$_GET["data"]][0][0]."'>
		</td>
	</tr>
	<tr>		
				<td>";
				if($tags[$_GET["data"]][4]["SIGNAL"]=="Analog")
				echo "	
				<p>
				<input type='radio' name='signalType1' id='signalType1' value='Analog' checked>
				<label for='signalType1'>Analog</label>
				</p>
				<p>
				<input type='radio' name='signalType1' id='signalType2' value='Digital'>
				<label for='signalType2'>Digital</label></p>";
				elseif ($tags[$_GET["data"]][4]["SIGNAL"]=="Digital") {					
					echo "	
				<p>
				<input type='radio' name='signalType1' id='signalType1' value='Analog' >
				<label for='signalType1'>Analog</label>
				</p>
				<p>
				<input type='radio' name='signalType1' id='signalType2' value='Digital' checked>
				<label for='signalType2'>Digital</label>
				</p>";
				}
				else
					echo "	
				<p>
				<input type='radio' name='signalType1' id='signalType1' value='Analog' >
				<label for='signalType1'>Analog</label>
				</p>
				<p>
				<input type='radio' name='signalType1' id='signalType2' value='Digital'>
				<label for='signalType2'>Digital</label>
				</p>";

				if($tags[$_GET["data"]][4]["IO"]=="Input")
				echo "
				</td>
				<td>
				<p>
				<input type='radio' name='inputType1' id='inputType1' value='Input' checked>
				<label for='inputType1'>Input</label>
				</p>
				<p>
				<input type='radio' name='inputType1' id='inputType2' value='Output'>
				<label for='inputType2'>Output</label>
				</p>
				</td>
				";
				elseif ($tags[$_GET["data"]][4]["IO"]=="Output") {
				echo "
				</td>
				<td>
				<p>
				<input type='radio' name='inputType1' id='inputType1' value='Input'>
				<label for='inputType1'>Input</label>
				</p><p>
				<input type='radio' name='inputType1' id='inputType2' value='Output' checked>
				<label for='inputType2'>Output</label>
				</p>
				</td>
				";
				}
				else
				echo "
				</td>
				<td>
				<p>
				<input type='radio' name='inputType1' id='inputType1' value='Input'>
				<label for='inputType1'>Input</label>
				</p><p>
				<input type='radio' name='inputType1' id='inputType2' value='Output'>
				<label for='inputType2'>Output</label>
				</p>
				</td>
				";
				echo "
				<td>
					<table>
					<tr>
					<td><b>Port No : </b></td> <td> <input type='text' name='portNo1' value='".$tags[$_GET["data"]][4]["PORT"]."'></td>
					</tr>
					<tr>
					<td><b>Port Count : </b></td><td><input type='text' name='portCount1' value='".$tags[$_GET["data"]][4]["COUNT"]."'></td>
					</tr>
					</table>
				</td>
				<td>
				<table>
					<tr>
					<td><b>Range Min : </b></td><td> <input type='text' name='min1' value='".$tags[$_GET["data"]][4]["MIN"]."'></td>
					</tr>
					<tr>
					<td><b>Range Max : </b></td> <td><input type='text' name='max1' value='".$tags[$_GET["data"]][4]["MAX"]."'></td>
					</tr>
				</table>
				</td>

				<td>
				<table>
					<tr>
					<td><b>DID : </b></td><td> <input type='text' name='did1' value='".$tags[$_GET["data"]][2][0]."'></td>
					</tr>
					<tr>
					<td><b>PID : </b></td> <td><input type='text' name='pid1' value='".$tags[$_GET["data"]][4]["PID"]."'></td>
					</tr>
				</table>
				</td>
				
	</tr>		
	<tr>
		<td><b>Type</b></td>
		<td>
		<select class='browser-default' name='in_type1'>";
		$options=array("input1","input2","input3");
		foreach ($options as $value) {
			echo "<option value='$value'";
			if($value==$tags[$_GET["data"]][4]["TYPE"])
				echo " selected";
			echo ">$value</option>";
		}

		  echo "
		</select>
		</td>
		<td>
";
echo "			 <input type='checkbox' id='singleWires1' name='singleWires1'" ; 

if($tags[$_GET["data"]][4]["WIRE"]=="true")
echo " selected" ;
echo"> <label for='singleWires1'>Single Wires</label>";
			 echo "	</td>	</tr></table>	";
?>
</div>
<input type="hidden" name="xml_str" id="xml_str" value="1"/>
<div class="myseperator"></div>
<div class="center"> 
<button class="btn" name="submit123" id="add">Add More</button>
<button class="btn" name="submit" id="submit">Submit</button>
<div>
	</form>
	<?php 
	if(isset($_POST['submit'])) {
		$myFileRead = new DOMDocument();
		$myFileRead->load('configuration2.xml');
		
		$xmlstr=$_POST['xml_str'];			
	  	$delim1 = explode(";", $xmlstr);
	  	$elementOld = $myFileRead->getElementsByTagName("modbus")[0];
	  	$element=$myFileRead->createElement("modbus");  	

	  	//////generating new elements in the array
	  	for ($i=0; $i <count($delim1)-1; $i++) { 


	  		if($i==0)
	  		{

			  		$delim2 = explode("|", $delim1[$i]);			  		
			  		$str=array($delim2[0]);	  			
			  		$did=array($delim2[7]);	
			  		$typ=array("JouleIO");	
			  		$signal=$delim2[1];
			  		$io=$delim2[2];
			  		$port=$delim2[3];
			  		$count=$delim2[4];
			  		$min=$delim2[5];
			  		$max=$delim2[6];
			  		$pid=$delim2[8];
			  		$type=$delim2[9];
			  		$wire=$delim2[10];

			  		$ji=array("SIGNAL"=>$signal,"IO"=>$io,"PORT"=>$port,"COUNT"=>$count,"MIN"=>$min,"MAX"=>$max,"PID"=>$pid,"TYPE"=>$type,"WIRE"=>$wire);
			  		// array_push($ji, $signal,$io,$port,$count,$min,$max,$pid,$typ,$wire);

			  		$md=array();
			  		$tempar=array($str,array($_GET["sid"]),$did,$typ,$ji);
			  		array_push($md,$tempar);			  		
			  		unset($tags[$_GET["data"]]);
			  		array_splice( $tags, $_GET["data"], 0, $md);

	  		}
	  		else
			{
	  		// echo "<br>".$i."<br>";

	  		$delim2 = explode("|", $delim1[$i]);	  		
	  		$str=array($delim2[0]);	  			
	  		$did=array($delim2[7]);	
	  		$typ=array("JouleIO");	
	  		$signal=$delim2[1];
	  		$io=$delim2[2];
	  		$port=$delim2[3];
	  		$count=$delim2[4];
	  		$min=$delim2[5];
	  		$max=$delim2[6];
	  		$pid=$delim2[8];
	  		$type=$delim2[9];
	  		$wire=$delim2[10];

	  		$ji=array("SIGNAL"=>$signal,"IO"=>$io,"PORT"=>$port,"COUNT"=>$count,"MIN"=>$min,"MAX"=>$max,"PID"=>$pid,"TYPE"=>$type,"WIRE"=>$wire);
	  		// array_push($ji, $signal,$io,$port,$count,$min,$max,$pid,$typ,$wire);

	  		$md=array();
	  		$tempar=array($str,array($_GET["sid"]),$did,$typ,$ji);
	  		array_push($md,$tempar);
	  		print_r($tempar);
	  		array_splice( $tags, $_GET["data"], 0, $md);
	  	}



	  	}
	
	  	//////generating end

		for($i=0;$i<count($tags);$i++)
	  	{
	  				$el="md".($i+1);
	  								
	  				
					$mdMAP=$myFileRead->createElement("mdMAP".($i+1));
					$mdMAP->appendChild($myFileRead->createTextNode("1"));

					$str=$myFileRead->createElement("STR");
					$str->appendChild($myFileRead->createTextNode($tags[$i][0][0]));

					$sid=$myFileRead->createElement("SID");
					$sid->appendChild($myFileRead->createTextNode($tags[$i][1][0]));

					$did=$myFileRead->createElement("DID");
					$did->appendChild($myFileRead->createTextNode($tags[$i][2][0]));

					$typ=$myFileRead->createElement("TYP");
					$typ->appendChild($myFileRead->createTextNode($tags[$i][3][0]));

					$ji=$myFileRead->createElement("JIO");
					
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
	  	$elementOld->parentNode->replaceChild($element, $elementOld);
		$myFileRead->save("configuration2.xml");	
		echo "<script>window.location='index.php'</script>";
	}
	?> 
</body>
</html>
