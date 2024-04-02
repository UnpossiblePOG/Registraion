<!DOCTYPE html>
<html lang="en">
<head>
  <title>NES</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>  
  <script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
  <style type="text/css">
  	.pagination-float{
  float: right;
}
.my-pagination li
{
  display: inline;
}
.my-pagination ul li
{
  list-style: none;
}
.my-pagination li a {
color:#777
}
.pull-right
{
  float: right !important;
}
.my-pagination > li > a, .my-pagination > li > span {
    position: relative;
    float: left;
    padding: 6px 12px;
    line-height: 1.428571429;
    text-decoration: none;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    margin-left: -1px;
}
.my-pagination > li > a {
    background-color: #E8E8E8;
}

.my-pagination .no-border{
  border: 0px solid #dddddd !important;
}
.error{
  color: red;
}

  </style>
</head>
<body>
  <?php
  if(isset($_SESSION['user_id']))
  {
  ?>
	<div class="jumbotron text-center">
  <h1>Hi</h1>
  <p>User</p> 
  <a href="users_list.php">OTHER USERS</a> |
  <a href="edit_user.php?id=<?php echo $_SESSION['user_id'];?>">VIEW / EDIT PROFILE</a> | 
  <a style="" onclick="return confirm('Want to logout?')" href="logout.php">LOGOUT</a>
</div>
<?php
}
?>