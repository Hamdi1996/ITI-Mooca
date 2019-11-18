<?php

$errors_arr=array();
if(isset($_GET['error_fields']))
{
    $errors_arr=explode(",",$_GET['error_fields']);
}
?>
<html>

<body>
    <form method="POST" action="process.php" >
    <label for="name">Name</label>
    <input type="text" name="name" id="name"/> 
    <?php if(in_array("name",$errors_arr)) echo "*please Enter your name"; ?><br>
    <label for="email">Email</label>
    <input type="email" name="email" id="email"/>
    <?php if(in_array("email",$errors_arr)) echo "*please Enter your Email"; ?><br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password"/>
    <?php if(in_array("password",$errors_arr)) echo "*please Enter your password"; ?><br>
    <label for="gender">Gender</label><br>
    <input type="radio" name="gender" value="Male"/>Male
    <input type="radio" name="gender" value="Female"/>Female
    <input type="submit" name="submit" value="Register"/>
    
    </form>

   
</body>
</html>