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
				required: true,
				minlength: 7,
			},
			conf_password: {
				minlength: 7,
				equalTo: "#password"
			},
			fileToUpload: {
				required: true,
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
			var password = $("input[name=password]").val();

			$.ajax({
				type: 'post',
				url: "check_unique.php",
				data: {
					email: email,
					password: password
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