<?php
 include('login.php'); // Includes Login Script

  if(isset($_SESSION['username'])){
    // Go to next page
    header("location: Front_End_1.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>
<div id="main">
<h1>Login Session</h1>
<div id="login">
<h2>Login Form</h2>
<form action="" method="post">
<label>UserName :</label>
<input id="name" name="username" placeholder="username" type="text">
<label>Password :</label>
<input id="password" name="password" placeholder="**********" type="password">
<input name="submit" type="submit" value=" Login ">
<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>
