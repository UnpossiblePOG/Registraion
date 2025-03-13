<?php
session_start();
$host = "localhost";
$dbname = "temp_1";
$user = "root";
$password = "";
$prep_db;
try 
{
	$prep_db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
	$prep_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} 
	catch (PDOException $e) 
	{
		echo "Incorrect DB connection";
		exit;
	} 
	finally 
	{
	}
include('common_functions.php');
?>