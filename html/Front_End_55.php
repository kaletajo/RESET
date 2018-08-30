<!DOCTYPE html>
<html>
<body>
<div id="rectangle"></div>
<div class ="content">
<div class ="container"> 
<body>
<h2>Question 54</h2>
<p><font size ="5.0"><strong>Describe your daily routine in detail.How do you feel about your daily activities?</strong></p>
<p><font size ="5.0">Upload a one minute video below</p></font>
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
  <br />
  <input type="submit" name="submit" value="Submit" font="bold"style="font-size:20px; width: 100px, height:40px;"/>
</form>

<!--
<form action="upload.php" method="post" enctype="multipart/form-data">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
-->

</body>
</html>


