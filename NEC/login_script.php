<?php
include_once('dbcon.php');
unset($_SESSION['user_id']);
if(isset($_POST['email'])&&isset($_POST['password']))
{
	$sql="SELECT id,full_name from admin_table where email=? and password=? and status=?";
	$result = commonPDOSelectQuery($prep_db,$sql,[$_POST['email'],md5(clean($prep_db,$_POST['password'])),1]);
	if (sizeof($result) > 0) 
	{
		foreach($result as $row)
		{
			$_SESSION['user_id']=$row['id'];
			$_SESSION['user_name']=$row['full_name'];
			addLog($prep_db,"User ID : ".$row['id']." logged in successfully","");
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