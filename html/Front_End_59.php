<!DOCTYPE html>
<html>
<body>

<p><strong>Imagine that something or someone has irritated you.How does it make you feel?</strong></p>
<p>Upload a one minute video below</p>

<form action="upload.php" method="post" enctype="multipart/form-data">
  <label for="file"><span>Filename:</span></label>
  <input type="file" name="file" id="file" /> 
  <br />
  <input type="submit" name="submit" value="Submit" />
</form>

<!--
<form action="upload.php" method="post" enctype="multipart/form-data">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
-->

</body>
</html>


