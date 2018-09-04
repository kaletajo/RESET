<?php
    session_start();
?>

<!--
  Main scoring function.
  Run scoring function - produce report
-->


<!DOCTYPE html>
<html>
<body>

<h1>Summary</h1>

Report Summary

<table style="width:100%">
  <tr>
    <th>Condition</th>
    <th>Measurement</th>
  </tr>
  <tr>
    <td>Anxiety</td>
    <td>50</td>
  </tr>
  <tr>
    <td>Depression</td>
    <td>94</td>
  </tr>
  <tr>
    <td>Psychosis</td>
    <td>80</td>
  </tr>
</table>


<form action="./index.html" >
  <br />
  <input type="submit" value="Finish">
</form>

</body>
</html>



<!-- Logout and finish -->
<?php
    // remove all session variables
    session_unset(); 

    // destroy the session 
    session_destroy(); 

    //header("location: index.php");
?>



