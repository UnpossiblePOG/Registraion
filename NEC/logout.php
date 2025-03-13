<?php
include_once('dbcon.php');
addLog($prep_db,"User ID : ".$_SESSION['user_id']." logged out successfully","");
session_destroy();
header('location: index.php');
?>