<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<div id="rectangle"></div>
<meta name="viewport" content="width=device-width, initial-scale=1">
<div class ="content">
<div class ="container"> 
<body>
<h1>Question 20</h1>
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
<div> 
<h2>Think about yourself for a while and answer this question</h2>
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest20" font="bold"style="font-size:20px; width: 100px, height:40px;">How would you describe yourself?</label>
      </div>
      <div class="col-75">
        <select id="quest20" name="q20" font="bold"style="font-size:20px; width: 100px, height:40px;">
          <option value="0">I do not feel sad</option>
          <option value="1">I am sad all the time and I often snap</option>
          <option value="2">I am so sad and unhappy that I can't stand it</option>
        </select>
       </div>
      </div>
      <br>
      <div class="row">
        <input type="submit" value="Submit"font="bold"style="font-size:20px; width: 100px, height:40px;">
      </div>
     </form>
    </div>
</body>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q20"]))
    {
    $q20 = $_POST['q20'];

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
        $sql = "UPDATE answers SET question20='" . $q20 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_21.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>

