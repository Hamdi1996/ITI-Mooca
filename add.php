<?php

$error_fields=array();
if($_SERVER['REQUEST_METHOD']=='POST'){
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
$password=sha1($_POST['password']);
$admin=(isset($_POST['admin']))? 1:0;

$upload_dir=$_SERVER['DOCUMENT_ROOT'].'/uploads';
$avatar='';
if($_FILES["avatar"]['error']==UPLOAD_ERR_OK)
{
    $tmp_name=$_FILES["avatar"]["tmp_name"];
    $avatar=basename($_FILES["avatar"]["name"]);
    move_uploaded_file($tmp_name,"$upload_dir/$avatar");

}
else
{
    echo "File can't be upload";
    exit;
}

$query="INSERT INTO `user`(`name`,`email`,`password`,`admin`) VALUES ('".$name."','".$email."','".$password."','".$admin."')";
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
}
?>
<?php

$errors_arr=array();
if(isset($_GET['error_fields']))
{
    $errors_arr=explode(",",$_GET['error_fields']);
}
?>
<html>
<title>Admin :: Add User</title>
<body>
    <form method="POST" enctype="multipart/form-data">
    <label for="name">Name</label>
    <input type="text" name="name" value="<?=(isset($_POST['name']))?$_POST['name']:''?>"/> 
    <?php if(in_array("name",$errors_arr)) echo "*please Enter your name"; ?><br>
    <label for="email">Email</label>
    <input type="email" name="email" value="<?=(isset($_POST['email']))?$_POST['email']:''?>"/>
    <?php if(in_array("email",$errors_arr)) echo "*please Enter your Email"; ?><br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password"/>
    <?php if(in_array("password",$errors_arr)) echo "*please Enter your password"; ?><br>
    <input type="checkbox" name="admin" <?=(isset($_POST['admin']))?'checked':''?> />Admin
    <br/>
    <label for="avatar">Avatar</label>
    <input type="file" name="avatar" id="avatar">

    <input type="submit" name="submit" value="Add User"/>
    
    </form>

   
</body>
</html>