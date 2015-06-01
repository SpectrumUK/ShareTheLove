$(document).ready(function () {

    var form = $("#rhForm");

    if (form.length) {


        $(form).validate({
            debug: true
        });

        $("#txtName").rules("add", {
           // minlength: 2,
            messages: {
                required: "Please enter a name"
            }
        });
        $("#txtWhatYouLove").rules("add", {
            //minlength: 2,
            messages: {
                required: "Please tell us what you love"
            }
        });
        $("#ddFileUnder").rules("add", {
            messages: {
                required: "Please select a category"
            }
        });
        //comp form fields
        $("#txtFirstName").rules("add", {
            minlength: 2,
            messages: {
                required: "Please enter your first name"
            }
        });
        $("#txtLastName").rules("add", {
            minlength: 2,
            messages: {
                required: "Please enter your last name"
            }
        });
        // $("#txtWhatYouLove").rules("add", {
            // minlength: 2,
            // messages: {
                // required: "Please tell us what you love"
            // }
        // });
        $("#txtDobDay").rules("add", {
            digits: true,
            range: [1, 31],
            messages: {
                digits: "Numeric only",
                range: "Invalid day",
                required: "Required"
            }
        });
        $("#txtDobMonth").rules("add", {
            digits: true,
            range: [1, 12],
            messages: {
                digits: "Numeric only",
                range: "Invalid month",
                required: "Required"
            }
        });
        $("#txtDobYear").rules("add", {
            digits: true,
            minlength: 4,
			check_date_of_birth: true,
            messages: {
                digits: "Numbers only",
                required: "Required",
				check_date_of_birth: "Over 18 only"
            }
        });
        $("#txtEmail").rules("add", {
            email: true,
            messages: {
                required: "Please enter a valid email address",
                email: "The email address entered is not valid"
            }
        });
        $("#ddCountry").rules("add", {
            messages: {
                required: "Please select country of residence"
            }
        });
        $("#cb2").rules("add", {
            messages: {
                required: "You have not agreed to our Terms and Conditions"
            }
        });
        $("#cb3").rules("add", {
            messages: {
                required: "This field is required"
            }
        });
    }

});