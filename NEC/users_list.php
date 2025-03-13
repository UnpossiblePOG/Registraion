<?php
include_once('dbcon.php');
$page=@$_GET['page'];
$start=0;
$per_page=5;
if($page!="")
{
	$start=(intval($page)-1)*$per_page;
}
include_once('admin_header.php');
include_once('common_header.php');
?>
<div class="container">
	<center>
		<?php
		if(isset($_SESSION['error']))
		{
			?>
			<h3 class="error"><?php echo $_SESSION['error'];?></h3>
			<?php
			unset($_SESSION['error']);
		}
		?>
		<?php
		if(isset($_SESSION['success']))
		{
			?>
			<h3 class="color-green"><?php echo $_SESSION['success'];?></h3>
			<?php
			unset($_SESSION['success']);
		}
		?>
	</center>
	<table width="100%" class="table table-responsive">
		<thead>
			<tr>
				<th width="80%">NAME</th>
				<th width="20%">ACTIONS</th>
			</tr>
		</thead>
		<?php
		$sql = "SELECT count(id) as cnt from admin_table where id !=? order by id desc";
		$result0 = commonPDOSelectQuery($prep_db,$sql,[$_SESSION['user_id']]);
		
		$total_results=$result0[0]['cnt'];
		$sql="SELECT * from admin_table where id !=? order by id desc limit $start,$per_page";
		$result = commonPDOSelectQuery($prep_db,$sql,[$_SESSION['user_id']]);
		if (sizeof($result) > 0) 
		{
			foreach($result as $row)
			{
				?>
				<tr>
					<td><?php echo $row['full_name'];?></td>
					<td>
						<a href="edit_user.php?id=<?php echo $row['id'];?>">VIEW PROFILE</a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
	<div class="row pagination-float">
		<?php
		echo pagination($total_results,"",$page,$per_page,$p1="",$p2="",$p3="");
		?>
	</div>
</div>
<?php
include_once('common_footer.php');
?>