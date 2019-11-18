<?php
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
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$query="DELETE FROM `user` WHERE `user`.`id`=".$id." LIMIT 1";

if(mysqli_query($conn,$query))
{
    header("Location:list.php");
    exit;
}
else
{
    echo mysqli_error($conn);
}
mysqli_close($conn);

?>