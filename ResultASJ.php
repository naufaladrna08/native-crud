<html>

<head>
<title>Instant Quiz Results</title>
</head>

<body bgcolor="#FFFFFF">

<p align="center"><strong><font face="Arial">

<script src="ASJQuiz.js">
</script>

<big>Instant Quiz Results</big></font></strong></p>
<div align="center"><center>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%"><form method="POST" name="ResultASJ"><table border="0" width="100%" cellpadding="0" height="116">
        <tr>
          <td height="25" bgcolor="#D3FFA8"><strong><font face="Arial"># of questions you got right:</font></strong></td>
          <td height="25"><p><input type="text" name="p" size="24"></td>
        </tr>
        <tr>
          <td height="17" bgcolor="#D3FFA8"><strong><font face="Arial">The questions you got wrong:</font></strong></td>
          <td height="17"><p><textarea name="T2" rows="3" cols="24" wrap="virtual"></textarea></td>
        </tr>
        <tr>
          <td height="25" bgcolor="#D3FFA8"><strong><font face="Arial">Grade in percentage:</font></strong></td>
          <td height="25"><input type="text" name="q" size="8"></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
</table>
</center></div>

<form method="POST"><div
  align="center"><center><p>

<script>
var wrong=0
for (e=0;e<=2;e++)
document.result[e].value=""

var results=document.cookie.split(";")
for (n=0;n<=results.length-1;n++){
if (results[n].charAt(1)=='q')
parse=n

}

var incorrect=results[parse].split("=")
incorrect=incorrect[1].split("/")
if (incorrect[incorrect.length-1]=='b')
incorrect=""
document.result[0].value=totalquestions-incorrect.length+" out of "+totalquestions
document.result[2].value=(totalquestions-incorrect.length)/totalquestions*100+"%"
for (temp=0;temp<incorrect.length;temp++)
document.result[1].value+=incorrect[temp]+", "


</script>

<input type="button" value="Take the quiz again" name="B1"
  onClick="history.go(-1)"> <input type="button" value="View solution" name="B2"
  onClick="showsolution()"></p>
  </center></div>
</form>

<p id="footnote" align="center"><font face="arial" size="-1">Quiz script provided by<br>
<a href="http://www.javascriptkit.com">JavaScriptKit.com</a></font></p>
</body>
</html>
