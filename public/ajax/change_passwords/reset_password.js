$(document).ready(function() {
    // Toast notifications
    var Toast = new Notyf({
        duration: 3000,
        position: {
            x: 'center',
            y: 'top',
        },
    });

    $("#reset-password").on("submit", function(e) {
        e.preventDefault();
        let waitingMessage;
        let form = $("#reset-password")[0];
        let formData = new FormData(form);
        let password = $("#password").val();
        if (password.length < 8) {
            $("#err-password").html("at leaset 8 character long.");
        } else {
            $("#err-password").html("");
            $.ajax({
                method: "POST",
                url: url + "change-password",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    waitingMessage = Toast.open({
                        type: 'info',
                        message: 'Sending...',
                        background: 'blue',
                        duration: 0,
                    });
                },
                success: function(responce) {
                    Toast.dismiss(waitingMessage);
                    if(responce == "1"){
                        window.location.href = url + "login";
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });
});