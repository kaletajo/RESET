<?php
    session_start();
?>


<!DOCTYPE html>
<html>
<div id="rectangle"></div>
<meta name="viewport" content="width=device-width, initial-scale=1">
<div class ="content">
<div class ="container"> 
<h1>Question 22</h1>
<h2>Think about yourself for a moment and then answer this question</h2> 
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
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest22"font="bold"style="font-size:20px; width: 100px, height:40px;">Which statement best describes you?</label>
      </div>
      <div class="col-75">
        <select id="quest22" name="q22" font="bold"style="font-size:20px; width: 100px, height:40px;">
          <option value="0">I don't get more tired than usual</option>
          <option value="1">I get tired more easily than I used to</option>
          <option value="2">I get tired from doing almost anything</option>
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
    if (isset($_POST["q22"]))
    {
    $q22 = $_POST['q22'];

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
        $sql = "UPDATE answers SET question22='" . $q22 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_23.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>

