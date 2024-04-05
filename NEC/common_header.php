<!DOCTYPE html>
<html lang="en">
<head>
  <title>NES</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/new-css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>  
  <script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
</head>
<body>
  <?php
  if(isset($_SESSION['user_id']))
  {
  ?>
	<div class="jumbotron text-center">
  <h1>Hi</h1>
  <p><?php echo $_SESSION['user_name'];?></p> 
  <a href="users_list.php">OTHER USERS</a> |
  <a href="edit_user.php?id=<?php echo $_SESSION['user_id'];?>">VIEW / EDIT PROFILE</a> | 
  <a onclick="return confirm('Want to logout?')" href="logout.php">LOGOUT</a>
</div>
<?php
}
?>