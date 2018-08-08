
<?php
    session_start();
?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
}

input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
}

label {
    padding: 12px 12px 12px 0;
    display: inline-block;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}

.col-25 {
    float: left;
    width: 25%;
    margin-top: 6px;
}

.col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
    .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 0;
    }
}
</style>
</head>
<body>

<h2>Mental Health Questionaire</h2>
<p>Fill in the following questionaire in order to help us to asses your mental state</p>



<div class="container">
  <form action="#" method="post">
    <div class="row">
      <div class="col-25">
        <label for="quest1">Have you ever been diagnosed with mental health problems</label>
      </div>
      <div class="col-75">
        <select id="quest1" name="q1">
          <option value="0">YES</option>
          <option value="1">NO</option>
          <!--
          <option value="0" <?= ($_POST['q1'] == "0")? "selected":"";?>>YES</option>
          <option value="1" <?= ($_POST['q1'] == "1")? "selected":"";?>>NO</option>
          -->
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="quest2">Did anyone of your parents have been diagnosed with mental health    problems</label>
      </div>
      <div class="col-75">
        <select id="quest2" name="q2">
          <option value="0">YES</option>
          <option value="1">NO</option>
        </select>
      </div>
     </div>
     <div class="row">
       <div class ="col-25">
         <label for="quest3">How happy would you consider yourself to be</label>
       </div>
       <div class="col-75">
         <select id="quest3" name="q3"</label>
          <option value="0">Happy</option>
          <option value="1">Somewhat happy</option>
          <option value="2">Not happy</option>
         </select>
       </div>
      </div>
      <div class="row">
        <div class ="col-25">
          <label for="quest4">How often do you get sad</label>
        </div>
        <div class="col-75">
          <select id="quest4" name="q4"</label>
          <option value="0">Often</option>
          <option value="1">Sometimes</option>
          <option value="2">Rarely</option>
          </select>
        </div>
       </div>
       <div class="row">
         <div class="col-25">
           <label for"quest5">How active is your social life</label>
         </div>
         <div class="col-75">
           <select id="quest5" name="q5"</label>
          <option value="0">Active</option>
          <option value="1">Somewhat active</option>
          <option value="2">Not active</option>
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


<h2>Rapid Self Esteem Tool</h2>
<p1>Upload your photo</p1>
<p2>Fill in the questionaire</p2>

</body>
</html>

<!-- This code executes when the FORM is submitted using POST method -->
<?php


    // Print POST variables
    echo '<pre>'.print_r($_POST,true).'</pre>';

    
    if((isset($_POST["q1"])) &&
       (isset($_POST["q2"])) &&
       (isset($_POST["q3"])) &&
       (isset($_POST["q4"])) &&
       (isset($_POST["q5"])) )
    {

    //if( $_POST["q1"] && $_POST["q2"] && $_POST["q3"] && $_POST["q4"] && $_POST["q5"])
    //{
    //echo "q1: ". $_POST['q1']. "<br />";
    //echo "q2: ". $_POST['q2']. "<br />";
    //echo "q3: ". $_POST['q3']. "<br />";
    //echo "q4: ". $_POST['q4']. "<br />";
    //echo "q5: ". $_POST['q5']. "<br />";

    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];
    $q3 = $_POST['q3'];
    $q4 = $_POST['q4'];
    $q5 = $_POST['q5'];

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
	$sql = "UPDATE answers SET question1='" . $q1 . "', " 
                               . " question2='" . $q2 . "', "
                               . " question3='" . $q3 . "', "
                               . " question4='" . $q4 . "', "
                               . " question5='" . $q5 . "'  "
                               . " WHERE user_id='" . $username . "' "
                               . " AND start_time ='" . $starttime . "' ";
	// use exec() because no results are returned
	$conn->exec($sql);

	// Close database connection
	$conn = null;

        if(isset($_SESSION['username'])){
          // Go to next page
          header("location: Front_End_2.php");
        }

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    }
?>


