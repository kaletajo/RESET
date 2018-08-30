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
<h2>Question 9</h2>
<video width="500" controls>
  <source src="video1.mp4" type="video/mp4">
</video>
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
<h2>Watch the video carefully, you will be asked a question about the content</h2>
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25" font="bold" style="font-size:20px; width: 100px, height:40px;">
        <label for="quest14"><b>What emotion do you see in the video</label>
      </div>
      <div class="col-75">
        <select id="quest14" name="q14" font="bold" style="font-size:20px; width: 100px, height:40px;">
          <br>
          <option value="0">Anxiety</option>
          <option value="1">Anger</option>
          <option value="2">Joy</option>
        </select>
       </div>
      </div>
      <br>
      <div class="row">
        <input type="submit" value="Submit" font="bold" style="font-size:20px; width: 100px, height:40px;">
      </div>
     </form>
    </div>
</body>
</html>

<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q14"]))
    {
    echo "q14: ". $_POST['q14']. "<br />";
    $q14 = $_POST['q14'];

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
        $sql = "UPDATE answers SET question14='" . $q14 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_11.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>

