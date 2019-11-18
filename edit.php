<?php

$error_fields=array();
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
$select="SELECT * FROM `user` WHERE `user`.`id`=" .$id. " LIMIT 1";
    $reslt=mysqli_query($conn,$select);
    $row=mysqli_fetch_assoc($reslt);


if($_SERVER['REQUEST_METHOD']=='POST'){
    if(!(isset($_POST['name'])&& !empty($_POST['name'])))
    {
        $error_fields[]="name";
    }
    
    if(!(isset($_POST['email'])&& filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)))
    {
        $error_fields[]="email";
    }
    if(!$error_fields)
    {

    $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    $name=mysqli_escape_string($conn,$_POST['name']);
    $email=mysqli_escape_string($conn,$_POST['email']);
    $password=(!empty($_POST['password']))?sha1($_POST['password']):$row['password'];
    $admin=(isset($_POST['admin']))? 1:0;
    }

    
    $query="UPDATE `user` SET `name`='".$name."',`email`='".$email."',
    `password`='".$password."',`admin`='".$admin."' WHERE `user`.`id`=".$id;
if(mysqli_query($conn,$query))
{
    header("Location:list.php");
    exit;
}
else
{
    echo mysqli_error($conn);
}}



    ?>


<?php

$errors_arr=array();
if(isset($_GET['error_fields']))
{
    $errors_arr=explode(",",$_GET['error_fields']);
}
?>


    <html>
<title>Admin :: Edit User</title>
<body>
    <form method="POST">
    <label for="name">Name</label>
    <input type="hidden" name="id" id="id" value="<?=(isset($row['id'])) ?$row['id']:'' ?>">
    <input type="text" name="name" value="<?=(isset($row['name']))?$row['name']:''?>"/> 
    <?php if(in_array("name",$errors_arr)) echo "*please Enter your name"; ?><br>
    <label for="email">Email</label>
    <input type="email" name="email"  value="<?=(isset($row['email']))?$row['email']:''?>"/>
    <?php if(in_array("email",$errors_arr)) echo "*please Enter your Email"; ?><br>
    <label for="password">Password</label>
    <input type="password" name="password"/>
    <?php if(in_array("password",$errors_arr)) echo "*please Enter your password"; ?><br>
    <input type="checkbox" name="admin" value="<?=(isset($row['admin']))?'checked':''?>"/>Admin

    <input type="submit" name="submit" value="Edit User"/>
    
    </form>

   
</body>
</html>