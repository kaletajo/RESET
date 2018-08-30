
<?php
    session_start();
?>


<!DOCTYPE html>
<html>
<div id="rectangle"></div>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>
<div class="content">
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25"><h2>&nbsp;&nbsp;&nbsp;&nbsp;<font size ="6.0">Question 1</h2>
        <label for="quest6"><font size ="6.0"><b>&nbsp;&nbsp;&nbsp;Do these photos represent neutral sentiment?</font><br>&nbsp;&nbsp;&nbsp;<font size="4.0">Select an answer from the drop down menu</font></b></label>
        <style>
        body{
        background-color:#90EE90
        }
        .content {
        max-width: 1000px;
        margin: auto;
        background: none;
        padding: 50px;
        }
      </style>
      <br>
      <br>
   &nbsp;&nbsp;&nbsp;<img src="sad3.jpeg" alt="Sad1" style="width:30%;">
   &nbsp;&nbsp;&nbsp;<img src="sad4.jpeg" alt="Sad2" style="width:30%;">
   &nbsp;&nbsp;&nbsp;<img src="sad21.jpeg" alt="Sad3" style="width:30%;">
      </div>
      <div class="col-75">
       &nbsp;&nbsp;&nbsp;<select id="quest6" name="q6" font="bold" style="font-size:20px; width: 100px, height:40px;"/>
          <option value="0">Agree</option>
          <option value="1">Neutral</option>
          <option value="2">Disagree</option>
        </select>
      </div>
    </div>
    <br>
    <div class="row">
       &nbsp;&nbsp;&nbsp;<input type="submit" value="Submit" font="bold" style="font-size:20px; width: 100px; height: 40px;"/>
    </div>
   </form>
  </div>
</body>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q6"]))
    {
    //echo "q6: ". $_POST['q6']. "<br />";
    $q6 = $_POST['q6'];

    // Read database config file and set-up db connection
    $db = parse_ini_file("../../database_conf.ini");
    $dbservername = $db['host'];
    $dbname = $db['name'];
    $dbusername = $db['user'];
    $dbpassword = $db['passwd'];
    $dbtype = $db['type'];

    $username = $_SESSION["username"];
    $starttime = $_SESSION["starttime"];

    try {
        $conn = new PDO("$dbtype:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully"; 
        $sql = "UPDATE answers SET question6='" . $q6 . "'  " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        echo $sql;
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_3.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
  }
?>





