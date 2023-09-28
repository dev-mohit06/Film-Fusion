//helper functions         
function showPopup(backdrop, formElement, backdropClass, formElementClass) {
    $(backdrop).addClass(backdropClass);
    $(formElement).addClass(formElementClass);
}

function closePopup(backdrop, formElement, backdropClass, formElementClass, popupContainer) {
    $(backdrop).removeClass(backdropClass);
    $(formElement).removeClass(formElementClass);
    if (popupContainer) {
        $(popupContainer).html("");
    }
}

// Toast notifications
var Toast = new Notyf({
    duration: 3000,
    position: {
        x: 'center',
        y: 'top',
    },
});

let waitingMessage;

$(document).ready(function() {

    //load users
    function loadOffers() {
        $.ajax({
            type: "GET",
            url: url + "admin/getAllOffers",
            success: function(response) {
                $(".table-data").html(response);
            }
        });
    }
    loadOffers();

    //insert
    $("#adduser_popup").on("click", function() {
        showPopup("#backdrop", "#add-form", "backdrop-show", "form-show");

        $("#insert-user-form").on("submit", function(e) {
            e.preventDefault();

            let form = $("#insert-user-form")[0];
            let formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: url + "admin/insertOffer",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    waitingMessage = Toast.open({
                        type: 'info',
                        message: "Just a moment...",
                        background: 'blue',
                        duration: 0,
                    });
                },
                success: function(response) {
                    loadOffers();
                    Toast.dismiss(waitingMessage);
                    Toast.success("Offer created successfully.");
                    closePopup("#backdrop", "#add-form", "backdrop-show",
                        "form-show", ".dif");
                    form.reset();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
    $("#backdrop").on("click", function() {
        closePopup("#backdrop", "#add-form", "backdrop-show", "form-show");
    });
    $("#adduser_popup_close").on("click", function() {
        closePopup("#backdrop", "#add-form", "backdrop-show", "form-show");
    });

    //update
    $(document).on("click", "#update-btn", function() {
        let offer_id = $(this).data("update_id");

        $.ajax({
            method: "GET",
            url: url + "admin/getOfferUpdateForm",
            data: {
                offer_id: offer_id,
            },
            beforeSend: function() {
                $(".data-loader").show();
                showPopup("#backdrop", "#update-form", "backdrop-show", "form-show");
            },
            success: function(responce) {
                $(".data-loader").hide();
                $(".duf").html(responce);

                $("#update-user-form").on("submit", function(e) {
                    e.preventDefault();

                    let form = $("#update-user-form")[0];
                    let formData = new FormData(form);
                    formData.append("offer_id",offer_id);

                    $.ajax({
                        method: "POST",
                        url: url + "admin/updateOffers",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            waitingMessage = Toast.open({
                                type: 'info',
                                message: "Just a moment...",
                                background: 'blue',
                                duration: 0,
                            });
                        },
                        success : function(value){
                            loadOffers();
                            Toast.dismiss(waitingMessage);
                            Toast.success("Offer update successfully.");
                            closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
                            console.log(value);
                        }
                    });

                });

            }
        });
    });
    $("#backdrop").on("click", function() {
        closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
    });
    $("#adduser_popup_close").on("click", function() {
        closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
    });

    //delete
    $(document).on("click","#delete-btn",function(){
        let offer_id = $(this).data("delete_id");

        $.ajax({
            method : "GET",
            url : url + "admin/deleteOffers",
            data : {
                offer_id : offer_id,
            },
            beforeSend : function(){
                waitingMessage = Toast.open({
                        type: 'info',
                        message: "Just a moment...",
                        background: 'blue',
                        duration: 0,
                    });
            },
            success : function(responce){
                loadOffers();
                Toast.dismiss(waitingMessage);
            }
        });
    });

});