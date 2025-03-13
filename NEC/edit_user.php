<?php
include_once('dbcon.php');
include_once('admin_header.php');
include_once('common_header.php');
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
$sql="SELECT * from admin_table where id=?";
$result = commonPDOSelectQuery($prep_db,$sql,[clean($prep_db,$_GET['id'])]);
$full_name = "";
$email = "";
$password = "";
$description = "";
$profile_picture = "";
$gender = "";
foreach($result as $row)
{
	$full_name = $row['full_name'];
	$email = $row['email'];
	$password = $row['password'];
	$description = $row['description'];
	$profile_picture = $row['profile_picture'];
	$gender = $row['gender'];
}
?>
<script src="https://cdn.ckeditor.com/4.16.0/full-all/ckeditor.js"></script>
<script src="js/edit.js"></script>
<div class="container">
	<div class="pt-75 col-md-10">
		<form action="add_user_script.php" method="post" enctype="multipart/form-data" id="register_form">
			<?php
			if($_SESSION['user_id']==$_GET['id'])
			{
				?>
				<input type="hidden" readonly="" class="form-control" name="id" value="<?php echo $_GET['id'];?>" autocomplete="off">
				<input type="hidden" readonly="" class="form-control" name="token" value="<?php echo $_SESSION['token'];?>" autocomplete="off">
				<br/>
				<label>Full Name <span class="error">*</span></label>
				<input type="text" class="form-control" name="full_name"  pattern="^[a-zA-Z\s]+$" autocomplete="off" value="<?php echo $full_name;?>">
				<br/>
				<label>Email Address <span class="error">*</span></label>
				<input type="text" class="form-control" name="email"  pattern="[^@\s]+@[^@\s]+\.[^@\s]+" autocomplete="off" value="<?php echo $email;?>" readonly>
				<br/>
				<label>Password <span class="error">*</span></label>
				<input type="password" class="form-control" name="password" id="password" autocomplete="off">
				<br/>
				<label>Confirm Password <span class="error">*</span></label>
				<input type="password" class="form-control" name="conf_password" autocomplete="off">
				<br/>
				<label>Profile Picture <span class="error">*</span></label>
				<input type="file" name="fileToUpload" id="fileToUpload" class="form-control" accept="image/*"  autocomplete="off">
				<br/>
				<center><div><img id="image_div"  src="<?php echo $profile_picture;?>" alt="No image found." class="image-height"></div></center>
				<br/>
				<label>Description</label>
				<textarea name="description"><?php echo $description;?></textarea>
				<br/>
				<label>Gender <span class="error">*</span></label>
				<select class="form-control" name="gender">
					<option value="m" <?php if($gender=='m'){ echo ' selected '; }?>>Male</option>
					<option value="f" <?php if($gender=='f'){ echo ' selected '; }?>>Female</option>
				</select>
				<br/>
				<input type="submit" class="btn btn-success" id="register-btn" name="Register" value="Save">
				<?php
			}
			else
			{
				?>
				<br/>
				<label>Full Name </label>
				<br/><?php echo $full_name;?>
				<hr/>
				<label>Email Address </label>
				<br/><?php echo $email;?>
				<hr/>
				<label>Profile Picture </label>
				<div><img id="image_div"  src="<?php echo $profile_picture;?>" alt="No image found." class="image-height"></div>
				<hr/>
				<label>Description</label>
				<br/><?php echo $description;?>
				<hr/>
				<label>Gender </label>
				<br/>
				<?php
				if($gender=='m'){ echo 'Male'; }else{echo 'Female';}
				?>
				<br/>
				<?php
				
			}
			?>
			<br/>
		</form>
	</div>
</div>
<script src="js/common.js"></script>
<?php
include_once('common_footer.php');
?>