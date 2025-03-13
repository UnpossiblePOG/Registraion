<?php
include_once('dbcon.php');
$status = "";
$msg = "";
if(isset($_POST['email']))
{
	$this_user = 0;
	if(isset($_SESSION['user_id']))
	{	
		$this_user = $_SESSION['user_id'];
	}
	$sql="SELECT * from admin_table where email=?  and id!=? ";
	$result = commonPDOSelectQuery($prep_db,$sql,[clean($prep_db,$_POST['email']),$this_user]);
	if (sizeof($result) == 0) 
	{
		$status = "success";
	}
	else
	{
		$status = "error";
		$msg = "Email ID already exists.";
	}
}
if(isset($_POST['password']))
{
	if($_POST['password']!='')
	{
		$num = checkValidPassword($_POST['password']);
		if($num==0)
		{
			$status = "error";
			$msg = "Password must contain at least one uppercase character, at least one lowercase character and at least one number.";
		}
	}	
}
echo json_encode(array("status"=>$status,"msg"=>$msg));exit;
?>