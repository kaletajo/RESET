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
</head>
<body>

<h2>Read the text carefully and answer a question</h2>
The most expensive brand of coffee today on the open market is known as Kopi Luwak, or civet coffee, from Indonesia. What makes this brand of coffee unique is that is made from the coffee beans eaten by the Asian palm civet. The civet eats the coffee berry for its fleshy pulp, along with the coffee bean inside, which is indigestible. However, while passing through the digestive system of the civet, proteolytic enzymes seep into the bean, making peptides shorter and increasing the number of free amino acids, improving the taste of the coffee bean. Similarly, due to the expensive and time-consuming process of searching for civet droppings, KOpi LUwak can be sold for up to $3000 per kilogram.

<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest7">Why does Civet digestion supposedly improve the coffee beans taste?</label>
      </div>
      <div class="col-75">
        <select id="quest7" name="q7">
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
    if (isset($_POST["q7"]))
    {
    //echo "q7: ". $_POST['q7']. "<br />";
    $q6 = $_POST['q7'];

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
        $sql = "UPDATE answers SET question7='" . $q7 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
        $conn->exec($sql);

       // Close database connection
        $conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_4.php");
        }
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>



