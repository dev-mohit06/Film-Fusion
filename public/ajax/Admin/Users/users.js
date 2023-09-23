 //FIXME: In this fileds json object the name key is your id for you input.
 const insertForm_fields = [{
    name: 'user-name',
    regex: /^[a-z0-9_\.]+$/,
    error: 'Only characters A-Z, a-z and \'_\' also 0-9 numbers  are  acceptable.'
},
{
    name: 'email',
    regex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
    error: 'Please enter a valid email address.'
},
{
    name: 'password',
    regex: /^.{8,}$/,
    error: 'Password must be greater than or equals to 8 characters.'
}
];

const updateForm_fields = [{
    name: 'update_username',
    regex: /^[a-z0-9_\.]+$/,
    error: 'Only characters A-Z, a-z and \'_\' are  acceptable.'
},
{
    name: 'update_email',
    regex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
    error: 'Please enter a valid email address.'
}
];

$(document).ready(function() {
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

    // Toast notifications
    var Toast = new Notyf({
        duration: 3000,
        position: {
            x: 'center',
            y: 'top',
        },
    });
    let insertingToast, updatingToast, deletingToast;


    //load users data
    function loadUsers() {
        $.ajax({
            method: "GET",
            url: url + "admin/getAllUsers",
            success: function(responce) {
                $(".userdata").html(responce)
            }
        });
    }
    loadUsers();

    // Insert user
    $("#adduserBtn").on("click", function() {

        $.ajax({
            method: "GET",
            url: url + "admin/getUserInsertForm",
            beforeSend: function() {
                $(".data-loader").show();
                showPopup("#backdrop", "#add-form", "backdrop-show", "form-show");
            },
            success: function(responce) {
                $(".dif").html(responce);
                $(".data-loader").hide();

                $("#insert-user-form").on("submit", function(e) {
                    e.preventDefault();
                    let count = 0;

                    // validation
                    insertForm_fields.forEach(field => {
                        let fieldValue = $("#" + field.name).val();
                        let errorElement = $("#err-" + field.name);
                        if (!fieldValue.match(field.regex)) {
                            errorElement.html(field.error);
                            count++;
                        } else {
                            errorElement.html("");
                        }
                    });

                    // if is true then it will run
                    if (count == 0) {
                        let form = $("#insert-user-form")[0];
                        let formData = new FormData(form);
                        $.ajax({
                            method: "POST",
                            url: url + "admin/insertWithSubscription",
                            data: formData,
                            beforeSend: function() {
                                insertingToast = Toast.open({
                                    type: 'info',
                                    message: "Just a moment...",
                                    background: 'blue',
                                    duration: 0,
                                });
                            },
                            processData: false,
                            contentType: false,
                            success: function(message) {
                                if (message == "1") {
                                    Toast.dismiss(insertingToast);
                                    loadUsers();
                                    closePopup("#backdrop",
                                        "#add-form",
                                        "backdrop-show",
                                        "form-show", ".dif");
                                    Toast.success(
                                        "Account created!");
                                } else {
                                    Toast.error(
                                        "User already exsist!!");
                                }
                            }
                        });
                    }

                });
            },
        });

    });
    $("#backdrop").on("click", function() {
        closePopup("#backdrop", "#add-form", "backdrop-show", "form-show", ".dif");
    });
    $("#adduser_popup_close").on("click", function() {
        closePopup("#backdrop", "#add-form", "backdrop-show", "form-show", ".dif");
    });

    // Update users
    $(document).on("click", "#updateuserBtn", function() {
        let userId = $(this).data("update_id");

        $.ajax({
            method: "GET",
            url: url + "admin/getUserUpdateForm",
            data: {
                userId: userId,
            },
            beforeSend: function() {
                $(".data-loader").show();
                showPopup("#backdrop", "#update-form", "backdrop-show", "form-show");
            },
            success: function(responce) {
                $(".duf").html(responce);
                $(".data-loader").hide();

                $("#update-user-form").on("submit", function(e) {
                    e.preventDefault();
                    // console.log("done");
                    let count = 0;

                    // Validation
                    updateForm_fields.forEach(field => {
                        let fieldValue = $("#" + field.name).val();
                        let errorElement = $("#err-" + field.name);
                        if (!fieldValue.match(field.regex)) {
                            errorElement.html(field.error);
                            count++;
                        } else {
                            errorElement.html("");
                        }
                    });

                    let password = $("#update_password").val();
                    if (password != "") {
                        passwordRegex = /^.{8,}$/;
                        if (!password.match(passwordRegex)) {
                            $("#err-update_password").html(
                                "Password must be greater than or equals to 8 characters."
                            );
                            count++;
                        } else {
                            $("#err-update_password").html("");
                        }
                    } else {
                        $("#err-update_password").html("");
                    }

                    let isValidProfile = profilePictureValidator($(
                        "#update-profile_picture"), $(
                        "#err-update-profile_picture"));

                    // if it's true then run
                    if (count == 0 && isValidProfile) {
                        let form = $("#update-user-form")[0];
                        let formData = new FormData(form);
                        formData.append("userId", userId);
                        $.ajax({
                            method: "POST",
                            url: url + "admin/updateWithSubscription",
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function() {
                                updatingToast = Toast.open({
                                    type: 'info',
                                    message: "Just a moment...",
                                    background: 'blue',
                                    duration: 0,
                                });
                            },
                            success: function(message) {
                                if (message == -1) {
                                    Toast.dismiss(updatingToast);
                                    Toast.error(
                                        "An account with this username or email already exists. Please choose a different username or email."
                                        );
                                } else {
                                    Toast.dismiss(updatingToast);
                                    Toast.success(
                                        "user's data has been updated successfully."
                                        );
                                    loadUsers();
                                    closePopup("#backdrop",
                                        "#update-form",
                                        "backdrop-show",
                                        "form-show", ".duf");
                                }
                                console.log(message);
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                });

            },
            error: function(e) {
                console.log(e);
            },
        });
    });
    $("#backdrop").on("click", function() {
        closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
    });
    $("#updateuser_popup_close").on("click", function() {
        closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
    });

    $(document).on("click", "#deleteuserBtn", function() {
        let userId = $(this).data("delete_id");

        if (confirm("Are you sure?")) {
            $.ajax({
                method: "GET",
                url: url + "admin/deleteUser",
                data: {
                    userId : userId,
                },
                beforeSend: function() {
                    deletingToast = Toast.open({
                        type: 'info',
                        message: "Just a moment...",
                        background: 'blue',
                        duration: 0,
                    });
                },
                success: function(responce) {
                    if (responce == 1) {
                        Toast.dismiss(deletingToast);
                        loadUsers();
                    }
                }
            });
        }
    });
});