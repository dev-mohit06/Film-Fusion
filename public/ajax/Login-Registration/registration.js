//Profile Picture validator
function profilePictureValidator(inputField, errField) {
    let pictureInput = inputField[0];
    let pictureErrorElement = errField;
    if (pictureInput.files.length > 0) {
        let pictureFile = pictureInput.files[0];
        let allowedFormats = ["image/jpeg", "image/png"]; // Add more formats if needed

        if (pictureFile.size > 5 * 1024 * 1024) { // 5MB maximum size
            pictureErrorElement.html("The profile picture size exceeds the limit of 5MB.");
            return false;
        } else if (!allowedFormats.includes(pictureFile.type)) {
            pictureErrorElement.html("Please upload a profile picture in JPEG or PNG format.");
            return false;
        } else {
            pictureErrorElement.html("");
            return true;
        }
    } else {
        pictureErrorElement.html("");
        return true;
    }
}


// Signup for inputs with it's appropriate regex and error
const sign_up_fields = [{
    name: 'username',
    regex: /^[a-z0-9_\.]+$/,
    error: 'Please enter a valid username'
},
{
    name: 'email',
    regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    error: 'Please enter a valid email address.'
},
{
    name: 'password',
    regex: /^.{8,}$/,
    error: 'at least 8 characters long.'
}
];


//Ajax
$(document).ready(function () {
    //signup form when submit
    $("#sign-up-form").on("submit", function (e) {
        e.preventDefault();

        //toast messages variables
        let accountCreatingMessage, successMessage, errorMessage;

        // Toast notifications
        var Toast = new Notyf({
            duration: 3000,
            position: {
                x: 'center',
                y: 'top',
            },
        });

        let count = 0;

        //validation logic
        sign_up_fields.forEach(field => {
            let fieldValue = $("#" + field.name).val();
            let errorElement = $("#err-" + field.name);

            if (!fieldValue.match(field.regex)) {
                errorElement.html(field.error);
                count++;
            } else {
                errorElement.html("");
            }
        });
        let valid = profilePictureValidator($("#profile_picture"), $("#err-profile_picture"));
        if (count == 0 && valid) {
            // Create a FormData object to capture form data if validation is complete
            let form = $(this)[0];
            let form_data = new FormData(form);

            $.ajax({
                type: "POST",
                url: url + "user-create", // Ajax backend url
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    accountCreatingMessage = Toast.open({
                        type: 'info',
                        message: 'Account creating...',
                        background: 'blue',
                        duration: 0,
                    })
                },
                success: function (response) {
                    if (response == 1) {
                        successMessage = Toast.success({
                            message: 'Account created! Redirecting to the next page shortly.',
                            dismissible: true,
                        });
                        Toast.dismiss(accountCreatingMessage);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    } else if (response == 0) {
                        errorMessage = Toast.error({
                            message: 'The user already exists. Please provide a different username or email.',
                            dismissible: true,
                        });
                        Toast.dismiss(accountCreatingMessage);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else { }
    });
});