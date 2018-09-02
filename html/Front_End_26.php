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
<h1>Question 26</h1> 
<h2>I have had stomach problems, such as feeling sick or stomach cramps</h2>
<div class="container">
  <form action="#" method="post">
  <div class="row">
    <div class="col-25">
      <label for="quest26"font="bold"style="font-size:20px; width: 100px, height:40px;">Do you agree with above statement?</label>
    </div>
    <div class="col-75">
      <select id="quest26" name="q26" font="bold"style="font-size:20px; width: 100px, height:40px;">
        <option value="0">Never</option>
        <option value="1">Sometime</option>
        <option value="2">Very often</option>
     </select>
    </div>
   </div>
   <br>
   <div class="row">
     <input type="submit" value="Submit" font="bold"style="font-size:20px; width: 100px, height:40px;">
   </div>
  </form>
 </div>
</body>
</html>

<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q26"]))
    {
    $q26 = $_POST['q26'];

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
        $sql = "UPDATE answers SET question26='" . $q26 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_27.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>

