if($('.custom-file-input')) {
	$('.custom-file-input').on("change", function(e) {
	    var fileName = $(this).val().split("\\").pop();
	    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
}