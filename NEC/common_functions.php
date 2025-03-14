<?php
/**
 * addLog function keeps track on every move of user.
 *
 * @param DB $prep_db is database connection.
 * @param string $action is an action taken by user.
 *
 * @return string $description more detail/response of user in json format.
 */
function addLog($prep_db,$action='',$description='')
{
	$action = clean($prep_db,$action);
	$description = clean($prep_db,$description);
	$qry_log="INSERT INTO logs(action,description,added_date)
	values(?,?,'".date("Y-m-d H:i:s")."')";
	$stmt = $prep_db->prepare($qry_log);
    $stmt->execute([$action,$description]);
}
/**
 * commonUserFieldValidation function validates user form.
 *
 * @param DB $prep_db is database connection.
 * @param string $full_name is user's first name.
 * @param string $email is user's email.
 * @param string $password is user's password.
 * @param string $conf_password is user's password reattempt.
 * @param string $gender is user's gender.
 * @param string $post_vals array post value.
 *
 * @return array $args is collection of arguments which will replace ? in sql query.
 */
function commonUserFieldValidation($prep_db,$full_name,$email,$password,$conf_password,$gender,$post_vals=[])
{
	$trimmedName = trim($full_name);
	$error_array = array();
    if (empty($trimmedName)) {
        $error_array[]= "Name cannot be empty or contain only spaces.";
    }
    if (!preg_match('/^[a-zA-Z\s]+$/', $trimmedName)) {
        $error_array[]= "Name can only contain alphabets and spaces.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
    	$this_user = 0;
    	if(isset($_SESSION['user_id']))
    	{	
    		$this_user = $_SESSION['user_id'];
    	}
    	$sql="SELECT * from admin_table where email=?  and id!=? ";
    	$result = commonPDOSelectQuery($prep_db,$sql,[clean($prep_db,$email),$this_user]);
    	if (sizeof($result) == 0) 
    	{
    	}
    	else
    	{
    		$error_array[]= "Email ID already exists.";
    	}
    }
    else 
    {
    	$error_array[]= "Email ID is not valid.";
    }
    if($password!="")
    {
    	if($password!=$conf_password)	
    	{
    		$error_array[]= "Password and confirm password do not match.";
    	}
    	else
    	{
    		$num = checkValidPassword($password);
			if($num==0)
			{
				$error_array[]= "Password must contain at least one uppercase character, at least one lowercase character and at least one number.";
			}
    	}
    }
    if($gender=="")
    {
    	$error_array[]= "Gender is not assigned.";
    }
    else if(!in_array($gender, array("m","f")))
    {
    	$error_array[]= "Incorrect gender value.";
    }
	return trim(implode("<br/>", $error_array));
}
/**
 * commonPDOInsertUpdateQuery function inserts/updates a data in table.
 *
 * @param DB $prep_db is database connection.
 * @param string $query is sql query.
 *
 * @return array $args is collection of arguments which will replace ? in sql query.
 */
function commonPDOInsertUpdateQuery($prep_db,$query='',$args=[])
{
	$stmt = $prep_db->prepare($query);
    $stmt->execute($args);
}
/**
 * commonPDOSelectQuery function gives a result.
 *
 * @param DB $prep_db is database connection.
 * @param string $query is sql query.
 *
 * @return array $where is collection of arguments which will replace ? in sql query.
 */
function commonPDOSelectQuery($prep_db,$query='',$where=[])
{
	$stmt = $prep_db->prepare($query);
    $stmt->execute($where);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
/**
 * admin_login_check function checks if user is logged in or not.
 *
 * @Session if not set, user will be redirected to login.
 */
function admin_login_check()
{
	if(!isset($_SESSION['user_id']))
	{
	  header("location: index.php");
	  exit;
	}
}
/**
 * clean function trims the strings (removes spaces from both side).
 *
 * @param DB $prep_db is database connection.
 * @param string $str is string.
 *
 * @return string $str.
 */
function clean($prep_db,$str) {
	return @trim($str);
}
/**
 * checkValidPassword function makes sure that user uses correct pattern for password.
 *
 * @param string $password is an input.
 *
 * @return int $return, if 0, then pattern does not match, if 1, then pattern matches.
 */
function checkValidPassword($password='')
{
	$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/'; 
	$return =0;
	if (preg_match($pattern, $password)) { 
		$return =1;
	}
	return $return;
}
/**
 * pagination function generates paginations.
 *
 * @param int $total_results is total result count.
 * @param string $targetpage is a common URL where page will be redicted when user clicks on any page number.
 * @param int $start is a count from where the result will start showing.
 * @param int $limit is total count of result per page.
 * @param string $limit is total count of result per page.
 * @param string $p1 & $p2 are request variable which can append in URL.
 * @param string $p3 can act like base URL.
 *
 * @return string $description more detail/response of user in json format.
 */
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
