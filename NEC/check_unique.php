<?php
include_once('dbcon.php');
$status = "";
$msg = "";
if(isset($_POST['email']))
{

	$extra_where = "";
	if(isset($_SESSION['user_id']))
	{
		$extra_where = " and id!='".$_SESSION['user_id']."' ";
	}

	$sql="SELECT * from admin_table where email='".clean($conn,$_POST['email'])."' $extra_where";
	$result = $conn->query($sql);
	if ($result->num_rows == 0)
	{
		$status = "success";
	}
	else
	{
		$status = "error";
		$msg = "Email ID already exists.";
	}
}
echo json_encode(array("status"=>$status,"msg"=>$msg));exit;
?>