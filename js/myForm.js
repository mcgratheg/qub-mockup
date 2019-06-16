jQuery(document).ready(function(){
	
	$("#myForm").validate({
		rules: {
			firstname: {
				required: true,
				minlength: 2
			},
			lastname: {
				required: true,
				minlength: 2
			},
			datepicker: "required",
			address: "required",
			city: "required",
			postcode: "required",
			email: {
				required: true,
				//qUBEmail: true
			},
			password: {
				required: true,
				minlength: 5
			},
			confirmpass: {
				required: true,
				minlength: 5,
				//equalTo: "#password"
			},
			title: "required",
			imginput: {
				extension: "png|jpeg",
			},
		},
		messages: {
			firstname: {
				required: "This field is required",
				minlength: "Name must be at least 2 characters",
			},
			lastname: {
				required: "This field is required",
				minlength: "Name must be at least 2 characters",
			},
			password: {
				required: "Please provide a password",
				minlength: "Password must be at least 5 characters",
			},
			confirmpass: {
				required: "Please provide a password",
				minlength: "Password must be at least 5 charachters"
				//equalTo: "Password must be the same as above"
			},
			imginput: {
				extension: "Image must be .png or .jpeg",
			},
				
		},
	});
		
	jQuery.validator.addMethod("qUBEmail", function(value, element){
			/^.+@qub.ac.uk$/.test(value);
	}, "Email must end in '@qub.ac.uk'.");

});