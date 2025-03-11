<?php
include_once('dbcon.php');
include_once('common_header.php');
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="js/add.js"></script>
<div class="container">
	<div class="pt-100" class="col-md-1">&nbsp;
		<a href="index.php">BACK</a>
	</div>
	<div class="pt-75" class="col-md-10">
		<form action="add_user_script.php" method="post" enctype="multipart/form-data" id="register_form">
			<center>
				<h2>
					Registration Form
				</h2>
				<?php
				if(isset($_SESSION['error']))
				{
					?>
					<!--This section is for showing all types of errors-->
					<h3 class="error"><?php echo $_SESSION['error'];?></h3>
					<?php
					unset($_SESSION['error']);
				}
				?>
			</center>


			<input type="hidden" readonly="" class="form-control" name="token" value="<?php echo $_SESSION['token'];?>" autocomplete="off">

			<br/>
			<label>Full Name <span class="error">*</span></label>
			<input type="text" class="form-control" name="full_name"  pattern="^[a-zA-Z\s]+$" autocomplete="off">

			<br/>
			<label>Email Address <span class="error">*</span></label>
			<input type="text" class="form-control" name="email"  pattern="[^@\s]+@[^@\s]+\.[^@\s]+" autocomplete="off">

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
			<center><div><img id="image_div" src="" alt="No image found." class="only-hide image-height"></div></center>

			<br/>
			<label>Description</label>
			<textarea name="description"></textarea>

			<br/>
			<label>Gender <span class="error">*</span></label>
			<select class="form-control" name="gender">
				<option value="m" >Male</option>
				<option value="f" >Female</option>
			</select>

			<br/>
			<input type="submit" class="btn btn-success" id="register-btn" name="Register" value="Register">
			<br/>
			<br/>
		</form>
	</div>
</div>
<script src="js/common.js"></script>
<?php
include_once('common_header.php');
?>