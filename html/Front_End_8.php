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
<h1>Question 7</h1>
<h2>Look at the image carefully and answer a question</h2>
<img src="anger.jpg" alt="Anger" style="width:30%;">
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
      <div class="col-25" font="bold" style="font-size:20px; width: 100px, height:40px;">
       <br>
       <label for="quest12"><b>What does this image says about you?</label>
       <br>
      </div>
      <div class="col-75">
       <br>
        <select id="quest12" name="q12" font="bold" style="font-size:20px; width: 100px, height:40px;">
          <option value="0">This image has nothing to do with me</option>
          <option value="1">This is how I often feel deep inside</option>
          <option value="2">I often react like this</option>
        </select>
      </div>
    </div>
    <div class="row">
    <br>
      <input type="submit" value="Submit" font="bold" style="font-size:20px; width: 100px, height:40px;">
    </div>
   </form>
  </div>
</body>
</head>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q12"]))
    {
    $q12 = $_POST['q12'];

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
        $sql = "UPDATE answers SET question12='" . $q12 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_9.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>




