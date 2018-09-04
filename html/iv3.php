<?php
    session_start();
?>


<!DOCTYPE html>
<html>
<div id="rectangle"></div>
<div class ="content">
<div class ="container"> 
<body>
<h2>Interactive Question 3</h2>
<p><font size ="5.0"><strong>Do you hear voices or sounds other people around you do not seem to hear?What do they usually say?Can you give me an example?</strong></p></font>
<p><font size ="5.0">Upload a video up to one minute long below</p></font>
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
  <label for="file"><span>Filename:</span></label>
  <input type="file" name="file" id="file" font="bold"style="font-size:20px; width: 100px, height:40px;"/> 
  <br/>
  <input type="submit" name="submit" value="Submit" font="bold"style="font-size:20px; width: 100px, height:40px;"/>
  <input type="hidden" id="qId" name="qId" value="question38">
</form>


</body>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    $_SESSION["next_page"] = "iv4.php";
?>

