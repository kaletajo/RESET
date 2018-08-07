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
<img src="anger.jpg" alt="Anger" style="width:20%;">
</head>
<body>

<h2>Look at the image carefully and answer a question</h2>
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for"quest12">What does this image says about you?</label>
      </div>
      <div class="col-75"
        <select id="quest12" name="q12">
          <option value="0">This image has nothing to do with me</option>
          <option value="1">This is how I often feel deep inside</option>
          <option value="2">I often react like this</option>
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
    if( $_POST["q12"])
    {
    echo "q12: ". $_POST['q12']. "<br />";
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
        $sql = "UPDATE answers SET question12='" . $q12 . "', " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        print($sql);
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



