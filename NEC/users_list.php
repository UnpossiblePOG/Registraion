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
$_SESSION['post_back_path']='admin_admin_table.php';
if($page!="")
{
	$_SESSION['post_back_path']='admin_admin_table.php?page='.$page;
}
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
					<h3 style="color: green;"><?php echo $_SESSION['success'];?></h3>
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

		$common_where = " where id !='".$_SESSION['user_id']."' ";

		$result0 = $conn->query("SELECT id from admin_table $common_where order by id desc");
		$total_results=$result0->num_rows;

		$sql="SELECT * from admin_table $common_where order by id desc limit $start,$per_page";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
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