<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">  
<div id="rectangle"></div>
<div class ="content">
<div class ="container"> 
<body>
<h2>Interactive Question 1</h2>
<p><font size ="5.0"><strong>How were things for you when you were growing up?</strong></p></font>
<p><font size ="5.0">(Answer question on video and upload video - up to one minute long)</p></font>
<style>
body {
    background-color:#90EE90
}
.content {
max-width: 1000px;
margin: auto;
background: none;
padding: 50px;
}
</style> 
<form action="upload.php" method="post" enctype="multipart/form-data">
  <label for="file"><span><font size="5.0">Filename:</font></span></label>
  <input type="file" name="file" id="file" font="bold" style="font-size:20px; width: 100px, height:40px;"/> 
  <br />
  <input type="submit" name="submit" value="Submit" font="bold"style="font-size:20px; width: 100px, height:40px;" />
  <input type="hidden" id="qId" name="qId" value="question36">
</form>


</body>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    $_SESSION["next_page"] = "iv2.php";
?>



