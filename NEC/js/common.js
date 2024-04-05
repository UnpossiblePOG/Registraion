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