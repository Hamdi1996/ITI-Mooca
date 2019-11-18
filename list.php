<?php

require 'user.php';
session_start();

$user =new user();

$users=$user->getUsers();
/*
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



$query="SELECT * FROM `user`";
$reslt=mysqli_query($conn,$query);
*/
?>
<html>
<head>
<title>Admin :: List Users</title>
</head>
<body>
    <h1> LIST Users</h1>
    
    <table>
    <tbody>
    <thead>
    <tr>
    <th>Id</th>
    <th>Name</th>
    <th>Email</th>
    <th>Admin</th>
    <th>Action</th>
    
    </tr>
    </thead>
    
<?php
while($row=mysqli_fetch_assoc($reslt))
{
    ?>
        <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['name']?></td>
        <td><?=$row['email']?></td>
        <td><?=($row['admin'])?'Yes':'No'?></td>
        <td><a href="edit.php?id=<?$row['id']?>">Edit</a> | <a href="delete.php?id=<?$row['id']?>">Delete</a></td>
        </tr>    
<?php
}
?>
</tbody>
<tfoot>

<tr>
<td colspan="2" style="text-align:center"><?=mysqli_num_rows($reslt)?><a>users</a></td>
<td colspan="3" style="text-align:center"><a href="add.php">Add User</a></td>
</tr>
</tfoot>
</table>
</body>

</html>

