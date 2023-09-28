const sign_in_fields = [{
    name: 'lg-username',
    regex: /^[a-z0-9_\.]+$/,
    error: 'Please enter a valid username'
},
{
    name: 'lg-password',
    regex: /^.{8,}$/,
    error: 'at least 8 characters long.'
}
];

$(document).ready(function () {
    $("#sign-in-form").on("submit", function (e) {
        e.preventDefault();

        //toast messages variables
        let loginMessage, successMessage, errorMessage;

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
        sign_in_fields.forEach(field => {
            let fieldValue = $("#" + field.name).val();
            let errorElement = $("#err-" + field.name);

            if (!fieldValue.match(field.regex)) {
                errorElement.html(field.error);
                count++;
            } else {
                errorElement.html("");
            }
        });

        if (count == 0) {
            const form = $(this)[0];
            let form_data = new FormData(form);
            $.ajax({
                type: "POST",
                url: url + "login",
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    loginMessage = Toast.open({
                        type: 'info',
                        message: 'Verifying your credentials...',
                        background: 'blue',
                        duration: 0,
                    });
                },
                success: function (response) {
                    // ADMIN
                    if (response == 1) {
                        successMessage = Toast.success({
                            message: 'Login Successfull, Welcome admin',
                            dismissible: true,
                        });

                        setTimeout(() => {
                            window.location.href = url + "admin/dashboard";
                        }, 2000);
                        Toast.dismiss(loginMessage);
                    }

                    // SUBSCRIBER
                    else if (response == 2) {
                        successMessage = Toast.success({
                            message: 'Welcome Back,',
                            dismissible: true,
                        });

                        setTimeout(() => {
                            window.location.href = url + "user/home";
                        }, 2000);
                        Toast.dismiss(loginMessage);
                    }

                    // NEW USER
                    else if (response == 3) {
                        successMessage = Toast.success({
                            message: 'Login Successfull',
                            dismissible: true,
                        });

                        setTimeout(() => {
                            window.location.href = url + "pricing";
                        }, 2000);
                        Toast.dismiss(loginMessage);
                    }

                    // NEW USER BUT ACCOUNT IS NOT ACTIVATED
                    else if (response == 4) {
                        errorMessage = Toast.open({
                            type: 'warning',
                            background: 'black',
                            message: 'Your account is not activated. We will resend an email verification link to your email.',
                            dismissible: true,
                        });
                        Toast.dismiss(loginMessage);
                    }

                    // INVALID PASSWORD
                    else if (response == 0) {
                        errorMessage = Toast.error({
                            message: 'Invalid password',
                            dismissible: true,
                        });
                        Toast.dismiss(loginMessage);
                    }

                    // ACCOUNT DELETED
                    else if (response == -2) {
                        errorMessage = Toast.error({
                            message: 'Account Deleted!!',
                            dismissible: true,
                        });
                        Toast.dismiss(loginMessage);
                    }

                    // USER DOESN'T EXSIST.
                    else {
                        errorMessage = Toast.open({
                            type: 'warning',
                            background: 'orange',
                            message: 'User not found. Please register.',
                            dismissible: true,
                        });
                        Toast.dismiss(loginMessage);
                    }
                }
            });
        }
    });
});