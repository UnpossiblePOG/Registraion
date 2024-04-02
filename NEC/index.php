<?php
session_start();
if(isset($_SESSION['user_id']))
{
	header("location: admin_admin_table.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div style="padding-top: 100px" class="col-md-4">
</div>
<div style="padding-top: 100px" class="col-md-4">
	<a href="add_user.php">Register</a>
	<center>
		<form action="login_script.php" method="post">
			<span style="color: red">
			<?php
			if(isset($_SESSION['invalid']))
			{
				echo "Invalid User";
				unset($_SESSION['invalid']);
			}
			?>
			<?php
				if(isset($_SESSION['success']))
				{
					?>
					<h3 style="color: green;"><?php echo $_SESSION['success'];?></h3>
					<?php
					unset($_SESSION['success']);
				}
				?>
			</span>
			<br/>
			<input type="text" class="form-control" name="email" autocomplete="off">
			<br/>
			<br/>
			<input type="password" class="form-control" name="password"  autocomplete="off">
			<br/>
			<br/>
			<input type="submit" name="submit" class="btn btn-success" value="login">
		</form>
	</center>
</div>
</body>
</html>