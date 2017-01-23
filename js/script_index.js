$(document).ready(function() {
    var count = $("#count_click").val();
    var xmlstr = "";
    $("#add").on('click', function(event) {
        event.preventDefault();
        /*localStorage.setItem('name', $("tr:last td input[id='str']").val());
          localStorage.setItem('sid', $("tr:last td input[id='sid']").val());
          localStorage.setItem('did', $("tr:last td input[id='did']").val());
         */
        count++;
        var str = "<tr>    <td><b>Device " + count + "</b></td>    <td><input type='text' name='str" + count + "' 'value ='' ></td>    <td>SID:</td>    <td><input type='text' name='sid" + count + "' 'value =''></td>    <td>DID:</td>    <td><input type='text' name='did" + count + "' 'value ='' ></td>    <td>Type:</td>    <td>       <select class='browser-default' name='typ" + count + "' data_val='" + count + "'><option value='NF29' selected>NF29</option><option value='Chiller'>Chiller</option><option value='VFD'>VFD</option><option value='EN8400'>EN8400</option><option value='JouleIO'>JouleIO</option>   </select></tr>";
        $('#dynamic tr:last').after(str);
        $("#count_click").val(count);
    });


    $("#submit").on('click', function(event) {

        for (var i = 1; i <= $("#count_click").val(); i++) {
            var str = $("input[name=str" + i + "]")[0].value;
            var sid = $("input[name=sid" + i + "]")[0].value;
            var did = $("input[name=did" + i + "]")[0].value;
            var typ = $("select[name=typ" + i + "]")[0];
            var typVal = typ.options[typ.selectedIndex].value;
            if (did == '' || sid == '' || str == '') {
                did = '0';
                sid = '0';
            }
            xmlstr += str + '|' + sid + '|' + did + '|' + typVal + ';';
        }

        $("#xml_str").val(xmlstr);

    });

    var click1Done = false;
    $("select").on('click', function() {
        customSelect($(this));
        click1Done = true;
    });

    function customSelect(obj) {
        el = obj[0];
        if (click1Done && el.value === 'JouleIO') {
            click1Done = false;
            var data = el.getAttribute("data_val");
            var sid = obj.parent().parent().children()[3];
            var sid_value = $(sid).children()[0].value;
            window.location = 'jouleIOIndex.php?data=' + data + '&sid=' + sid_value;
        }
    }

});


function deleteEntry(param) {
    var newvar = param;
    $('#deletebtn' + newvar).parent().parent().children()[3].innerHTML = "<input type='text' name='sid" + newvar + "' value=''>";
    $('#submit').click();
}
