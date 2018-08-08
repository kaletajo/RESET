
<?php
    session_start();
?>


<!DOCTYPE html>
<html>
<head>
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
<img src="sad3.jpeg" alt="Sad1" style="width:20%;">
<img src="sad4.jpeg" alt="Sad2" style="width:20%;">
<img src="sad21.jpeg" alt="Sad3" style="width:20%;">
</head>
<body>

<h2>Look at the photos carefully and answer the question</h2>

<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest6">Do these photos represent neutral sentiment?</label>
      </div>
      <div class="col-75">
        <select id="quest6" name="q6">
          <option value="0">YES</option>
          <option value="1">NO</option>
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





