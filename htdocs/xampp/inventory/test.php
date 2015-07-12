<html>
<head>
<script>
function showUser(key, upc) {
    var x = key.which || key.keyCode;

    if (x == 13) {
        if (upc == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            alert(xmlhttp.repsonseText);
                }
            }
            xmlhttp.open("GET","test2.php?q="+upc,true);
            xmlhttp.send();
        }
    }
}
</script>
</head>
<body>


<input id ="upc" type="text" name="upc" autofocus onkeypress="showUser(event, this.value)">

<br>
<div id="txtHint"><b>Person info will be listed here...</b></div>

</body>
</html>