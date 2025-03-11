<?php
include_once('dbcon.php');

$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);


if (!$token || $token !== $_SESSION['token'])
{
	$_SESSION['error']="Registration Failed.";
	header("location: add_user.php");exit;

}
else
{
	//removing single quotes from strings
	$full_name=clean($conn,$_POST['full_name']);
	$email=clean($conn,$_POST['email']);
	$password=md5($_POST['password']);
	$description=clean($conn,$_POST['description']);
	$gender=clean($conn,$_POST['gender']);

	//Sanitizing input
	$full_name = filter_var($full_name,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$description = filter_var($description,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$gender = filter_var($gender,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	if (strpos(str_replace(" ", "", $description),'<script') !== false)
	{
		$_SESSION['success']="Invalid Input.";
		if(isset($_POST['id']))
		{
			header("location: users_list.php");exit;
		}
		else
		{
			header("location: index.php");exit;
		}
	}
	$id=0;
	if(isset($_POST['id']))
	{

		if(trim($_POST['full_name'])=="" || trim($_POST['email'])=="" || trim($_POST['gender'])=="" ||$_POST['password']!=$_POST['conf_password'])
		{
			$_SESSION['error']="Invalid Information.";
		}

		$id=clean($conn,$_POST['id']);
		if($id!=$_SESSION['user_id'])
		{
			$_SESSION['error']="Updation Not Allowed.";
			header("location: users_list.php");exit;
		}

		addLog($conn,"Profile data of User ID : ".$id." updated",json_encode($_POST));

		$qry="UPDATE admin_table set 
		full_name='$full_name',
		description='$description',
		gender='$gender'
		where id='".$_SESSION['user_id']."'
		";
		$_SESSION['user_name'] = $full_name;
		$output=$conn->query($qry);
		if(trim($_POST['password'])!="")
		{
			$qry="UPDATE admin_table set 
			password='$password'
			where id='".$_SESSION['user_id']."'
			";
			$output=$conn->query($qry);
		}
	}
	else
	{

		if(trim($_POST['full_name'])=="" || trim($_POST['email'])=="" || trim($_POST['password'])=="" || trim($_POST['gender'])=="" || strlen($_POST['password']) < 6 ||$_POST['password']!=$_POST['conf_password'])
		{
			$_SESSION['error']="Invalid Information.";
			header("location: add_user.php");exit;
		}
		try
		{
			$qry="INSERT INTO admin_table(full_name,email,password,description,gender,added_date)
			values('$full_name','$email','$password','$description','$gender','".date("Y-m-d H:i:s")."')
			";
			$output=$conn->query($qry);
			$id=$conn->insert_id;
			addLog($conn,"New user ID : ".$id." created",json_encode($_POST));
		}
		catch (Exception $e) {
    		$_SESSION['error']="Caught an exception: " . $e->getMessage();
			header("location: add_user.php");exit;
		}
	}

	if(isset($_FILES["fileToUpload"]["name"]))
	{
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$final_image_path="";

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" )
		{
			$uploadOk = 0;
			$final_image_path="";
		}
		else
		{
			$final_image_path=$target_dir.$id.'-'.strtotime(date("Y-m-d H:i:s")).".".$imageFileType;

			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "".$final_image_path)) {
				$qry="UPDATE admin_table set 
				profile_picture='$final_image_path'
				where
				id='$id'
				";	
				$conn->query($qry);
				addLog($conn,"Profile picture of User ID : ".$id." updated",json_encode(array("image_path"=>$final_image_path)));
			}
		}	
	}
	if(isset($_POST['id']))
	{
		$_SESSION['success']="Data updated.";
		header("location: users_list.php");exit;
	}
	else
	{
		$_SESSION['success']="Registration successful.";
		header("location: index.php");exit;
	}
}
exit;
?>