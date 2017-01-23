$(document).ready(function() {
    var count = 1;
    var xmlstr = "";
    $("#add").click(function(event) {
        event.preventDefault();
        count++;
        $("#count_click").val(count);
        var str = "<div class='card'><hr><table>  <tr>        <td>        <b>Name</b>     </td>       <td>        <input type='text' name='name" + count + "' value=''>       </td>   </tr>   <tr>    <table      <tr>            <td>            <input type='radio' name='signalType" + count + "' id='signalType" + count+1 + "' value='Analog'><label for='signalType" + count+1 + "'>Analog</label>            <input type='radio' name='signalType" + count + "' id='signalType" + (count + 2) + "' value='Digital'><label for='signalType" + (count + 2) + "'>Digital</label>       </td>           <td>            <input type='radio' name='inputType" + count + "' id='inputType" + count+1 + "' value='Input'><label for='inputType" + count+1 + "'>Input</label>    <input type='radio' name='inputType" + count + "' id='inputType"+(count+2)+"'value='Output'><label for='inputType"+(count+2)+"'>Output</label>        </td>           <td><table>                 <tr>                    <td><b>Port No : </b></td> <td> <input type='text' name='portNo" + count + "' value=''></td>                    </tr>                   <tr>                    <td><b>Port Count : </b></td><td><input type='text' name='portCount" + count + "' value=''></td>                    </tr>       </table></td>           <td>    <table>                 <tr>                    <td><b>Range Min : </b></td><td> <input type='text' name='min" + count + "' value=''></td>                  </tr>                   <tr>                    <td><b>Range Max : </b></td> <td><input type='text' name='max" + count + "' value=''></td>  </tr>               </table>                </td>       <td>                <table>                 <tr>                    <td><b>DID : </b></td><td> <input type='text' name='did" + count + "' value=''></td>                    </tr>                   <tr>                    <td><b>PID : </b></td> <td><input type='text' name='pid" + count + "' value=''></td>                    </tr>               </table>                </td>               </tr>           <tr>        <td><b>Type</b></td>        <td>        <select class='browser-default' name='in_type" + count + "'>        <option value='input1'>input1</option>        <option value='input2'>input2</option>          <option value='input3'>input3</option>        </select>       </td>       <td>             <input type='checkbox' id='singleWires" + count + "' name='singleWires1'><label for='singleWires" + count + "'>Single Wires</label></td>   </tr></table></div>";
        $('.myseperator').after(str);
    });

    $("#submit").click(function(event) {
        for (var i = 1; i <= $("#count_click").val(); i++) {
            var name = $("input[name=name" + i + "]")[0].value;
            if (name == '') { name = 'null'; }
            var signalType = $("input[name=signalType" + i + "]:checked")[0].value;
            var inputType = $("input[name=inputType" + i + "]:checked")[0].value;
            var portNo = $("input[name=portNo" + i + "]")[0].value;
            if (portNo == '') { portNo = 'null'; }
            var portCount = $("input[name=portCount" + i + "]")[0].value;
            if (portCount == '') { portCount = 'null'; }
            var min = $("input[name=min" + i + "]")[0].value;
            if (min == '') { min == 'null'; }
            var max = $("input[name=max" + i + "]")[0].value;
            if (max == '') { max == 'null'; }
            var did = $("input[name=did" + i + "]")[0].value;
            if (did == '') { did = 'null'; }
            var pid = $("input[name=pid" + i + "]")[0].value;
            var in_type = $("select[name=in_type" + i + "]")[0];
            var in_typeVal = in_type.options[in_type.selectedIndex].value;
            var singleWires = $("input[name=singleWires" + i + "]")[0];
            var singleWiresVal = false;
            if ($(singleWires).is(':checked')) {
                singleWiresVal = true;
            }
            var deviceId = $("#deviceId").val();

            xmlstr += name + '|' + signalType + '|' + inputType + '|' + portNo + '|' + portCount + '|' + min + '|' + max + '|' + did + '|' + pid + '|' + in_typeVal + '|' + singleWiresVal + ';';
        }

        $("#xml_str").val(xmlstr);

    });

});
