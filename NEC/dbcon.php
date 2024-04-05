<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "temp_1";
$data_array=array();
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
function admin_login_check()
{
	if(!isset($_SESSION['user_id']))
	{
	  header("location: index.php");
	  exit;
	}
}
function clean($conn,$str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysqli_real_escape_string($conn,$str);
}

function checkValidPassword($password='')
{
	$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/'; 

	$return =0;

	if (preg_match($pattern, $password)) { 
		$return =1;
	}

	return $return;
}


function pagination($total_results,$targetpage,$start,$limit,$p1="",$p2="",$p3="")
{
	if($p1!="")
	{
		$cnd="&$p1";
	}
	else
	{
		$cnd="";
	}
	if($p2!="")
	{
		$cnd1="&$p2";
	}
	else
	{
		$cnd1="";
	}
	$adjacents = 3;   
	$page = $start;
	if($page) 
		$start = ($page - 1) * $limit; 			
	else
		$start = 0;
	if ($page == 0) $page = 1;					
	$prev = $page - 1;							
	$next = $page + 1;							
	$lastpage = ceil($total_results/$limit);		
	$lpm1 = $lastpage - 1;		
	$pagination = "";
	$total_count_last=($start+$limit);
	if($total_count_last>$total_results)
	{
		$total_count_last=$total_results;
	}
	$start_from=$start+1;
	if($total_results==0)
	{
		$start_from=0;
	}

	$total_count_result= "<li><span class='no-border'>Results: ".$start_from."-".$total_count_last." of ".$total_results."</span></li>";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"my-pagination pull-right\">";
		$pagination .= $total_count_result;
		if ($page > 1) 
			$pagination.= "<li><a href=\"$p3?page=$prev$targetpage".$cnd.$cnd1."\"> Previous</a></li>";
		else
			$pagination.= "<li><a class=\"disabled\">Previous</a></li>";
		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><span class=\"current\">$counter</span></li>";
				else
					$pagination.= "<li><a href=\"$p3?page=$counter$targetpage".$cnd.$cnd1."\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	
		{
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$p3?page=$counter$targetpage".$cnd.$cnd1."\">$counter</a></li>";					
				}
				$pagination.= "<li><a>...</a></li>";
				$pagination.= "<li><a href=\"$p3?page=$lpm1$targetpage\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$p3?page=$lastpage$targetpage".$cnd.$cnd1."\">$lastpage</a></li>";		
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$p3?page=1$targetpage".$cnd.$cnd1."\">1</a></li>";
				$pagination.= "<li><a href=\"$p3?page=2$targetpage".$cnd.$cnd1."\">2</a></li>";
				$pagination.= "<li><a>...</a></li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$p3?page=$counter$targetpage".$cnd.$cnd1."\">$counter</a></li>";					
				}
				$pagination.= "<li><a>...</a></li>";
				$pagination.= "<li><a href=\"$p3?page=$lpm1$targetpage".$cnd.$cnd1."\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$p3?page=$lastpage$targetpage".$cnd.$cnd1."\">$lastpage</a></li>";		
			}
			else
			{
				$pagination.= "<li><a href=\"$p3?page=1$targetpage".$cnd.$cnd1."\">1</a></li>";
				$pagination.= "<li><a href=\"$p3?page=2$targetpage".$cnd.$cnd1."\">2</a></li>";
				$pagination.= "<li><a>...</a></li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$p3?page=$counter$targetpage".$cnd.$cnd1."\">$counter</a></li>";					
				}
			}
		}
		if ($page < $counter - 1) 
			$pagination.= "<li><a href=\"$p3?page=$next$targetpage".$cnd.$cnd1."\" class=\"disabled\">Next </a></li>";
		else
			$pagination.= "<li><a class=\"disabled\"> Next</a> </li>";
		$pagination.= "</ul>\n";		
	}
	else
	{
		$pagination .= "<ul class=\"pagination pull-right\">";
		$pagination .= $total_count_result;
		$pagination.= "</ul>\n";		
	}
	return $pagination;
}
?>