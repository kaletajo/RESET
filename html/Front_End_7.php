<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.dropbtn {
    background-color: #3498DB;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
    background-color: #2980B9;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
<body>
Europa is the sixth closest moon of the planet Jupiter, and one of the largest moons in the solar system. Europa is slightly smaller that the Earth's moon and has a tenuous atmosphere composed primary of oxygen. The surface of Europa is composed of water and it is one of the smoothest in the solar system. Scientists suggest that it is possible Europa has an ocean of liquid water beneath its surface, making it a strong candidate for extra-terrestrial life. It is also predicted that heat energy from tidal flexing may cause oceans to remain liquid and drives geological activity similar to plate tectonics on Earth. 

<p>After reading the text answer the following question</p>
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest11">What makes Europa a potential home to extra-terrestrial life?</label>
      </div>
      <div class="col-75">
        <select id="quest11" name="q11">
          <option value="0">Ocean below its surface</option>
          <option value="1">Atmosphere comprised of oxygen</option>
          <option value="2">Geological activity</option>
        </select>
      </div>
     </div>
     <div class="row">
       <input type="submit" value="Submit">
     </div>
    </form>
  </div>

</body>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q11"]))
    {
    $q11 = $_POST['q11'];

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
        $sql = "UPDATE answers SET question11='" . $q11 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_8.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>

