<?php

  session_start(); 
  $error=''; 


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST['submit'])) {

  if (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Username or Password is invalid";
     
  }
  else
  {
    // Get POST variables
    $username=$_POST['username'];
    $password=$_POST['password'];
    
    // Tidy input and store as session variables 
    $username = test_input($username);
    $password = test_input($password);
    $_SESSION["username"] = $username;
    $starttime = date("Y-m-d H:i:s");
    $_SESSION["starttime"] = $starttime;

    // Read database config file and set-up db connection
    $db = parse_ini_file("../../database_conf.ini");
    $dbservername = $db['host'];
    $dbname = $db['name'];
    $dbusername = $db['user'];
    $dbpassword = $db['passwd'];
    $dbtype = $db['type'];
    $sec_passwd  = $db['sec_passwd'];

      
    // Secure password only check
    if ($sec_passwd != $password) {
	$_SESSION['username'] = NULL;
        $error = "Username or Password is invalid";
    }
    else {
        try {
            $conn = new PDO("$dbtype:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully"; 
            $sql = "INSERT INTO answers (user_id, start_time)
		        VALUES ('" . $username . "', '" . $starttime . "')";
	    // use exec() because no results are returned
            $conn->exec($sql);
	    echo "New record created successfully<br>";

	    // Close database connection
	    $conn = null;

        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

  }
}
?>
