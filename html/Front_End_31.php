<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<div id="rectangle"></div>
<body>
<div class ="content">
<div class ="container"> 
<h1>Question 31</h1>
<h2>At times I am very sociable and other times I just want to be left alone</h2>
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
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest31"font="bold" style="font-size:20px; width: 100px, height:40px;">Does the above statement reflects how you feel</label>
    </div>
      <div class="col-75">
        <select id="quest31" name="q31" font="bold"style="font-size:20px; width: 100px, height:40px;">
          <option value="0">Not at all</option>
          <option value="1">A little</option>
          <option value="2">Quite a lot</option>
        </select>
       </div>
      </div>
      <br>
      <div class="row">
        <input type="submit" value="Submit" font="bold"style="font-size:20px; width: 100px, height:40px;">
      </div>

</body>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q31"]))
    {
    $q31 = $_POST['q31'];

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
        $sql = "UPDATE answers SET question31='" . $q31 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_32.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>


