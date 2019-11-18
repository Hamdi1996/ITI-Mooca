<?php

$error_fields=array();

if(!(isset($_POST['name'])&& !empty($_POST['name'])))
{
    $error_fields[]="name";
}

if(!(isset($_POST['email'])&& filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)))
{
    $error_fields[]="email";
}



if(!(isset($_POST['password'])&& strlen($_POST['password'])>5))
{
    $error_fields[]="password";
}

if($error_fields)
{
    header("Location:form.php?error_fields=".implode(",",$error_fields));
}


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

$name=mysqli_escape_string($conn,$_POST['name']);
$email=mysqli_escape_string($conn,$_POST['email']);
$password=mysqli_escape_string($conn,$_POST['password']);

$query="INSERT INTO `user`(`name`,`email`,`password`) VALUES ('".$name."','".$email."','".$password."')";

if(mysqli_query($conn,$query))
{
    echo "DONe";
}
else
{
    //echo $query;
    echo mysqli_error($conn);
}
/*
$query="SELECT *FROM `user`";
$reslt=mysqli_query($conn,$query);
while ($row = mysqli_fetch_assoc($reslt))
{
    echo "ID:".$row['id']."<br>";
    echo "name:".$row['name']."<br>";
    echo"Email:".$row['email']."<br>";
    echo str_repeat("-",50)."<br>";
}

mysqli_free_result($reslt);
*/
mysqli_close( $conn);
?>