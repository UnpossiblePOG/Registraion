<?php
include_once('dbcon.php');
include_once('admin_header.php');
include_once('common_header.php');
$_SESSION['token'] = md5(uniqid(mt_rand(), true));

$sql="SELECT * from admin_table where id='".clean($conn,$_GET['id'])."'";
$result = $conn->query($sql);
$full_name = "";
$email = "";
$password = "";
$description = "";
$profile_picture = "";
$gender = "";

while($row = $result->fetch_assoc())
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
<div class="container">
	<div style="padding-top: 75px" class="col-md-10">
		<form action="add_user_script.php" method="post" enctype="multipart/form-data" id="register_form">

			<input type="hidden" readonly="" class="form-control" name="id" value="<?php echo $_GET['id'];?>" autocomplete="off">

			<input type="hidden" readonly="" class="form-control" name="token" value="<?php echo $_SESSION['token'];?>" autocomplete="off">

			<br/>
			<label>Full Name <span class="error">*</span></label>
			<input type="text" class="form-control" name="full_name"  pattern="^[a-zA-Z\s]+$" autocomplete="off" value="<?php echo $full_name;?>">

			<br/>
			<label>Email Address <span class="error">*</span></label>
			<input type="text" class="form-control" name="email"  pattern="[^@\s]+@[^@\s]+\.[^@\s]+" autocomplete="off" value="<?php echo $email;?>" readonly>
			<?php
			if($_SESSION['user_id']==$_GET['id'])
			{
			?>
			<br/>
			<label>Password <span class="error">*</span></label>
			<input type="password" class="form-control" name="password" id="password" autocomplete="off">

			<br/>
			<label>Confirm Password <span class="error">*</span></label>
			<input type="password" class="form-control" name="conf_password" autocomplete="off">
			<?php
			}
			?>
			<br/>
			<label>Profile Picture <span class="error">*</span></label>
			<input type="file" name="fileToUpload" id="fileToUpload" class="form-control" accept="image/*"  autocomplete="off">
			<br/>
			<center><div><img id="image_div"  src="<?php echo $profile_picture;?>" alt="No image found." style="height: 300px"></div></center>

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
			<?php
			if($_SESSION['user_id']==$_GET['id'])
			{
			?>
			<input type="submit" class="btn btn-success" id="register-btn" name="Register" value="Save">
			<?php
			}
			?>
			<br/>
		</form>
	</div>
</div>
<script>
	CKEDITOR.replace( 'description' );
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$("#image_div").show();
				$('#image_div').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#fileToUpload").change(function(){
		readURL(this);
	});

</script>
<script type="text/javascript">

	$(document).ready(function() {



		$("#register_form").validate({

			rules: {
				full_name: 
				{
					required: true,
					normalizer: function(value) {
						return $.trim(value);
					}
				},
				email: 
				{
					required: true,
					normalizer: function(value) {
						return $.trim(value);
					}
				},
				password: {
					minlength: 5,
				},
				conf_password: {
					minlength: 5,
					equalTo: "#password"
				},
				fileToUpload: {
					extension: "jpg|jpeg|png|JPG|JPEG|PNG"
				}
			},
			messages: {
				full_name: {
					pattern: "Please enter only alpha value."
				},
				email: {
					pattern: "Please enter valid email."
				},
				conf_password: {
					equalTo: "Confirm password should match with the password above this."
				},
			},
			submitHandler: function(form, event){
				var bool = false;
				$("#register-btn").attr("disabled", "disabled");

				var email = $("input[name=email]").val();

				$.ajax({
					type: 'post',
					url: "check_unique.php",
					data: {
						email: email
					},
					async: false,
					beforeSend: function(f) {},
					success: function(data) {
						var tempJson = JSON.parse(data);
						if (tempJson.status === "success") {
							bool = true;
							form.submit();
						} else {
							alert(tempJson.msg);
							$("#register-btn").removeAttr("disabled");
							event.preventDefault();
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(textStatus);
						$("#register-btn").removeAttr("disabled");
					}
				});
				

			}

		});

	});

</script>
<?php
include_once('common_header.php');
?>