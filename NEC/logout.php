<?php
include_once('dbcon.php');
session_destroy();
header('location: index.php');
?>