//helper functions         
function showPopup(backdrop, formElement, backdropClass, formElementClass) {
    $(backdrop).addClass(backdropClass);
    $(formElement).addClass(formElementClass);
}

function closePopup(backdrop, formElement, backdropClass, formElementClass, popupContainer) {
    $(backdrop).removeClass(backdropClass);
    $(formElement).removeClass(formElementClass);
    $(popupContainer).html("");
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

// read
function loadPlans() {
    $.ajax({
        type: "GET",
        url: url + "admin/getAllPlans",
        success: function(response) {
            $(".table-data").html(response);
        },
        error: function(err) {
            console.log(err);
        }
    });
}
loadPlans();

// insert
$("#adduser_popup").on("click", function() {
    showPopup("#backdrop", "#add-form", "backdrop-show", "form-show");

    $("#insert-user-form").on("submit", function(e) {
        e.preventDefault();

        let form = $("#insert-user-form")[0];
        let formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: url + "admin/insertPlan",
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
            success: function(response) {
                Toast.dismiss(waitingMessage);
                Toast.success("Plan Created!!");
                loadPlans();
                closePopup("#backdrop", "#add-form", "backdrop-show",
                    "form-show", ".dif");
            }
        });
    });

});
$("#backdrop").on("click", function() {
    closePopup("#backdrop", "#add-form", "backdrop-show", "form-show", ".dif");
});
$("#adduser_popup_close").on("click", function() {
    closePopup("#backdrop", "#add-form", "backdrop-show", "form-show", ".dif");
});

//update
$(document).on("click", "#update-btn", function() {
    let plan_id = $(this).data("update_id");
    $.ajax({
        type: "GET",
        url: url + "admin/getPlanUpdateForm",
        data: {
            plan_id: plan_id,
        },
        beforeSend: function() {
            $(".data-loader").show();
            showPopup("#backdrop", "#update-form", "backdrop-show", "form-show");
        },
        success: function(response) {
            $(".data-loader").hide();
            $(".duf").html(response);


            $("#update-user-form").on("submit", function(e) {
                e.preventDefault();

                let form = $("#update-user-form")[0];
                let formData = new FormData(form);
                formData.append("plan_id", plan_id);
                $.ajax({
                    type: "POST",
                    url: url + "admin/updatePlan",
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
                    success: function(response) {
                        Toast.dismiss(waitingMessage);
                        Toast.success(
                            "Plan details update successfully"
                        );
                        closePopup("#backdrop", "#update-form",
                            "backdrop-show", "form-show",
                            ".duf");
                        loadPlans();
                    }
                });
            });
        },
        error: function(err) {
            console.log(err);
        }
    });
});
$("#updateuser_popup_close").on("click", function() {
    closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
});
$("#backdrop").on("click", function() {
    closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
});

//delete
$(document).on("click", "#delete-btn", function() {
    let plan_id = $(this).data("delete_id");
    let con = confirm("Are you sure");

    if (con) {
        $.ajax({
            type: "GET",
            url: url + "admin/deletePlan",
            data: {
                plan_id: plan_id,
            },
            beforeSend: function() {
                waitingMessage = Toast.open({
                    type: 'info',
                    message: "Just a moment...",
                    background: 'blue',
                    duration: 0,
                });
            },
            success: function(response) {
                Toast.dismiss(waitingMessage);
                Toast.success("Plan delete successfully");
                loadPlans();
            }
        });
    }
});