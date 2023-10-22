$(document).ready(function() {
    const Toast = new Notyf({
        position: {
            x: 'center',
            y: 'top',
        },
    });

    let message;

    $("#send-invitation").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: url + "user/send-invitation",
            data: {
                reciver_email: $("#email").val(),
            },
            beforeSend: function() {
                loginMessage = Toast.open({
                    type: 'info',
                    message: 'Invitation Sending!!',
                    background: 'blue',
                    duration: 0,
                });
            },
            success: function(response) {
                if (response == "1") {
                    Toast.dismiss(loginMessage);
                    Toast.success({
                        message: "Invitation send successfully!!",
                        dismissible: true,
                    });
                } else {
                    Toast.dismiss(loginMessage);
                    Toast.error({
                        message: "The user already exsist!!",
                        dismissible: true,
                    });
                }
                $("#modal-container").removeClass("show-modal")
            },
            error: function(err) {
                console.log(err);
            }
        });

    });
});