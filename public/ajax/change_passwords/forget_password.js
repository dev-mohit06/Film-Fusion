$(document).ready(function() {
    // Toast notifications
    var Toast = new Notyf({
        duration: 3000,
        position: {
            x: 'center',
            y: 'top',
        },
    });

    $("#forget-password").on("submit", function(e) {
        e.preventDefault();
        let waitingMessage;
        let form = $("#forget-password")[0];
        let formData = new FormData(form);
        $.ajax({
            method: "POST",
            url: url + "sendForgetLink",
            data: formData,
            contentType : false,
            processData : false,
            beforeSend: function() {
                waitingMessage = Toast.open({
                    type: 'info',
                    message: 'Sending...',
                    background: 'blue',
                    duration: 0,
                });
            },
            success : function(responce){
                Toast.dismiss(waitingMessage);
                if(responce == -1){
                    Toast.error("Invalid Email Address!!");
                }else{
                    Toast.success("Link sent successfully");                            
                }
            },
            error : function(error){
                console.log(error);
            }
        });
    });
});