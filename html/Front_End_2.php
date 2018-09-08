<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<body>
<h1>Question 2</h1>
<h2>Read the text carefully and then answer the question</h2>
<font size="4.0"><b>The most expensive brand of coffee today on the open market is known as Kopi Luwak, or civet coffee, from Indonesia. What makes this brand of coffee unique is that is made from the coffee beans eaten by by the Asian palm civet. The civet eats the coffee berry for its fleshy pulp, along with the coffee bean inside, which is indigestible. However, while passing through the digestive system of the civet, proteolytic enzymes seep into the bean, making peptides shorter and increasing the number of free amino acids, improving the taste of the coffee bean. Similarly, due to the expensive and time-consuming process of searching for civet droppings, Kopi Luwak can be sold for up to $3000 per kilogram.
</font>
<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest2"><font size="5.0"><br>Why does Civet digestion supposedly improve the coffee beans taste?</font></label>
        <style>
        body{
        background-color:#90EE90
        }
        .content {
        max-width: 1000px;
        margin: auto;
        background: none;
        padding: 50px;
        }
        </style>
      </div>
      <div class="col-75">
      <br>
        <select id="quest2" name="q2" font="bold" style="font-size:20px; width: 100px, height:40px;"/><br>
          <option value="0">Lengthens coffee bean peptides</option>
          <option value="1">Removes coffee bean peptides</option>
          <option value="2">Shortens coffee bean peptides</option>
          <option value="3">Inceases the number of coffee bean peptides</option>
        </select>
      </div>
    </div>
    <br>
    <div class="row">
      <input type="submit" value="Submit" font="bold" style="font-size:20px; width: 100px; height: 40px;">
    </div>
   </form>
 </div>
</body>
</head>
</html>


<!-- This code executes when the FORM is submitted using POST method -->
<?php
    if (isset($_POST["q2"]))
    {
    //echo "q2: ". $_POST['q2']. "<br />";
    $q2 = $_POST['q2'];

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
        $sql = "UPDATE answers SET question2='" . $q2 . "' " 
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
        // use exec() because no results are returned
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



