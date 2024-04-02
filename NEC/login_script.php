<?php
include_once('dbcon.php');
unset($_SESSION['user_id']);
if(isset($_POST['email'])&&isset($_POST['password']))
{
	$sql="SELECT id,full_name from admin_table where email='".clean($conn,$_POST['email'])."' and password='".md5(clean($conn,$_POST['password']))."' and status='1'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$_SESSION['user_id']=$row['id'];
			$_SESSION['user_name']=$row['full_name'];
		}
	}
	else
	{
		$_SESSION['invalid']='1';		
	}
}
else
{
	$_SESSION['invalid']='1';
}
if(isset($_SESSION['invalid']))
{
	header("location: index.php");
}
if(isset($_SESSION['user_id']))
{
	header("location: users_list.php");
}