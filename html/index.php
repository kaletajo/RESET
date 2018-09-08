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
</head>
<body>
<div id="main">
<h1>Welcome to the RESET System</h1>
<p>Remote Mental Health Assessment Tool</p>
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
