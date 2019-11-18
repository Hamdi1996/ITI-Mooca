<?php

session_start();
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "users";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
if(!$conn)
{
    echo mysqli_connect_error();
    exit;
}

$email=mysqli_escape_string($conn,$_POST['email']);
$password=sha1($_POST['password']);
$query="SELECT * FROM `user` WHERE `email`='".$email."' and `password`='".$password."' LIMIT 1";
$reslt=mysqli_query($conn,$query);
if($row=mysqli_fetch_assoc($reslt))
{
    $_SESSION['id']=$row['id'];
    $_SESSION['email']=$row['email'];
    header("Location:list.php");
    exit;
}
else{
    $error="Invalid email or password";
}
}
?>


<html>
<head>
<title>Login</title>
</head>
<body>
<?php
if (isset($error)) echo $error;?>

<form action="post">
<label for="email">Email</label>
<input type="email" name="email" id="email" value="<?=(isset($_POST['email']))?$_POST['email']:''?>">
<label for="password">Password</label>
<input type="password" name="password" id="password"><br>
<br>
<input type="submit" name="submit" value="Login">
</form>

</body>
</html>