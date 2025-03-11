<?php
include_once('dbcon.php');
addLog($conn,"User ID : ".$_SESSION['user_id']." logged out successfully","");
session_destroy();
header('location: index.php');
?>