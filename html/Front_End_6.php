<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<h2>Question 6</h2>
<body>
<div class="col-25" font="bold" style="font-size:20px; width: 100px, height:40px;"><b>
Europa is the sixth closest moon of the planet Jupiter, and one of the largest moons in the solar system. Europa is slightly smaller than the Earth's moon and has a tenuous atmosphere composed primarily of oxygen. The surface of Europa is composed of water and it is one of the smoothest in the solar system. Scientists suggest that it is possible Europa has an ocean of liquid water beneath it's surface, making it a strong candidate for extra-terrestrial life. It is also predicted that heat energy from tidal flexing might cause oceans to remain liquid and drives geological activity similar to plate tectonics on Earth.
<p>After reading the text answer the following question</p>
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25" font="bold" style="font-size:20px; width: 100px, height:40px;">
        <label for="quest6"><font size ="5.0">What makes Europa a potential home to extra-terrestrial life?</font></label>
      </div>
      <div class="col-75" font="bold" style="font-size:20px; width: 100px, height:40px;">
        <select id="quest6" name="q6" font="bold" style="font-size:20px; width: 100px, height:40px;">
          <br>
          <option value="0">Ocean below its surface</option>
          <option value="1">Atmosphere comprised of oxygen</option>
          <option value="2">Geological activity</option>
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
<style>
body {
    background-color:#90EE90
}
</style>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q6"]))
    {
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
        $sql = "UPDATE answers SET question6='" . $q6 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_7.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>

