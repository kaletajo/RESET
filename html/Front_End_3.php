<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<div id="rectangle"></div>
<head>
<body>
<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="content">
<div class="container">
<h1>Question 3</h1>
<font size ="5.0"><b>Perform Following calculations</font>
<br>
<br>
<font size ="5.0"><b>2 * 3 - 1 = ?</font> 
<br>
<font size ="5.0"><b>15 + 16 - 7 = ?</font>
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <br>
        <label for="quest3"><font size ="4.0">What are the results of both calculations?</font></label>
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
      </div>
      <div class="col-75">
      <br>
        <select id="quest3" name="q3" font="bold" style="font-size:20px; width: 100px, height:40px;"/>
          <br>
          <option value="0">5, 24</option>
          <option value="1">4, 21</option>
        </select>
      </div>
     </div>
     <div class="row">
     <br>
     <br>
       <input type="submit" value ="Submit" font="bold" style="font-size:20px; width: 100px; height: 40px;">
     </div>
    </form>
  </div>
</body>
</html>

<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q3"]))
    {
    $q3 = $_POST['q3'];

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
        $sql = "UPDATE answers SET question3='" . $q3 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_4.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>

