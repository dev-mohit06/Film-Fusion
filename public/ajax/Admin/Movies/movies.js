$(document).ready(function() {
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

    // read
    function loadMovies() {
        $.ajax({
            method: "GET",
            url: url + "admin/getAllMovies",
            beforeSend: function() {},
            success: function(responce) {
                $(".movies-container").html(responce);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
    loadMovies();

    // insert
    $("#addmovie_popup").on("click", function() {
        showPopup("#backdrop", "#add-form", "backdrop-show", "form-show");
        let count = 0;

        $("#insert-movie-form").on("submit", function(e) {
            e.preventDefault();

            //picture validations
            // For hero-pic
            const pictureInput1 = $("#hero-pic")[0];
            const pictureErrorElement1 = $("#err-hero-pic");
            if (pictureInput1.files.length > 0) {
                const heroPic = pictureInput1.files[0];
                const allowedFormats = ["image/jpeg",
                "image/png"]; // Add more formats if needed

                if (heroPic.size > 5 * 1024 * 1024) { // 5MB maximum size
                    pictureErrorElement1.html(
                        "The profile picture size exceeds the limit of 5MB.");
                    count++;
                } else if (!allowedFormats.includes(heroPic.type)) {
                    pictureErrorElement1.html(
                        "Please upload a profile picture in JPEG or PNG format.");
                    count++;
                } else {
                    pictureErrorElement1.html("");
                }
            } else {
                pictureErrorElement1.html("");
            }

            // For banner
            const pictureInput2 = $("#banner")[0];
            const pictureErrorElement2 = $("#err-banner");
            if (pictureInput2.files.length > 0) {
                const banner = pictureInput2.files[0];
                const allowedFormats = ["image/jpeg",
                "image/png"]; // Add more formats if needed

                if (banner.size > 5 * 1024 * 1024) { // 5MB maximum size
                    pictureErrorElement2.html(
                        "The profile picture size exceeds the limit of 5MB.");
                    count++;
                } else if (!allowedFormats.includes(banner.type)) {
                    pictureErrorElement2.html(
                        "Please upload a profile picture in JPEG or PNG format.");
                    count++;
                } else {
                    pictureErrorElement2.html("");
                }
            } else {
                pictureErrorElement2.html("");
            }


            // For movie-file
            const pictureInput3 = $("#movie-file")[0];
            const pictureErrorElement3 = $("#err-movie-file");
            if (pictureInput3.files.length > 0) {
                const allowedFormats = ["video/mp4",
                "video/x-matroska"]; // Add more formats if needed
                const file = pictureInput3.files[0];
                if (!allowedFormats.includes(file.type)) {
                    pictureErrorElement3.html("Please upload a valid video file.");
                    count++;
                } else {
                    pictureErrorElement3.html("");
                }
            }

            if (count == 0) {

                let form = $("#insert-movie-form")[0];
                let formData = new FormData(form);

                $.ajax({
                    method: "POST",
                    url: url + "admin/insertMovie",
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        // Create an XMLHttpRequest object with progress tracking
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(
                        event) {
                            if (event.lengthComputable) {
                                var percentComplete = (event.loaded /
                                        event.total) *
                                    100;
                                // Update your progress UI here
                                $("#progressBar").val(percentComplete);
                            }
                        }, false);
                        return xhr;
                    },
                    beforeSend: function() {
                        $("#progressBar").removeClass("hideProgress");
                        $("#progressTitle").removeClass("hideProgress");
                        $("#backdrop").css('pointer-events', 'none');
                        $("#addmovie_popup_close").css("display", "none");
                    },
                    success: function(response) {
                        $("#progressBar").addClass("hideProgress");
                        $("#progressTitle").addClass("hideProgress");
                        $("#backdrop").css('pointer-events', 'all');
                        $("#addmovie_popup_close").css("display", "block");
                        if (response == 1) {
                            closePopup("#backdrop", "#add-form",
                                "backdrop-show",
                                "form-show");
                            form.reset();
                            loadMovies();
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    },
                });
            }
        });

    });
    $("#backdrop").on("click", function() {
        $("#insert-movie-form")[0].reset();
        closePopup("#backdrop", "#add-form", "backdrop-show", "form-show");
    });
    $("#addmovie_popup_close").on("click", function() {
        $("#insert-movie-form")[0].reset();
        closePopup("#backdrop", "#add-form", "backdrop-show", "form-show");
    });

    // update
    $(document).on("click", "#update_btn", function() {
        let waiting_message;
        let currentMovie = $(this).data('update_id');
        $.ajax({
            method: "GET",
            url: url + "admin/getMovieUpdateForm",
            beforeSend: function() {
                $(".data-loader").show();
                showPopup("#backdrop", "#update-form", "backdrop-show", "form-show");
            },
            data: {
                'movie_id': currentMovie,
            },
            success: function(responce) {
                $(".data-loader").hide();
                $(".duf").html(responce);

                $("#update-movie-form").on("submit", function(e) {
                    e.preventDefault();

                    let count = 0;

                    //picture validations
                    // For hero-pic
                    const pictureInput1 = $("#update-hero-pic")[0];
                    const pictureErrorElement1 = $("#err-update-hero-pic");
                    if (pictureInput1.files.length > 0) {
                        const heroPic = pictureInput1.files[0];
                        const allowedFormats = ["image/jpeg",
                            "image/png"
                        ]; // Add more formats if needed

                        if (heroPic.size > 5 * 1024 *
                            1024) { // 5MB maximum size
                            pictureErrorElement1.html(
                                "The profile picture size exceeds the limit of 5MB."
                                );
                            count++;
                        } else if (!allowedFormats.includes(heroPic.type)) {
                            pictureErrorElement1.html(
                                "Please upload a profile picture in JPEG or PNG format."
                            );
                            count++;
                        } else {
                            pictureErrorElement1.html("");
                        }
                    } else {
                        pictureErrorElement1.html("");
                    }

                    // For banner
                    const pictureInput2 = $("#update-banner")[0];
                    const pictureErrorElement2 = $("#err-update-banner");
                    if (pictureInput2.files.length > 0) {
                        const banner = pictureInput2.files[0];
                        const allowedFormats = ["image/jpeg",
                            "image/png"
                        ]; // Add more formats if needed

                        if (banner.size > 5 * 1024 * 1024) { // 5MB maximum size
                            pictureErrorElement2.html(
                                "The profile picture size exceeds the limit of 5MB."
                                );
                            count++;
                        } else if (!allowedFormats.includes(banner.type)) {
                            pictureErrorElement2.html(
                                "Please upload a profile picture in JPEG or PNG format."
                            );
                            count++;
                        } else {
                            pictureErrorElement2.html("");
                        }
                    } else {
                        pictureErrorElement2.html("");
                    }


                    // For movie-file
                    const pictureInput3 = $("#update-movie-file")[0];
                    const pictureErrorElement3 = $("#err-update-movie-file");
                    if (pictureInput3.files.length > 0) {
                        const allowedFormats = ["video/mp4",
                            "video/x-matroska"
                        ]; // Add more formats if needed
                        const file = pictureInput3.files[0];
                        if (!allowedFormats.includes(file.type)) {
                            pictureErrorElement3.html(
                                "Please upload a valid video file.");
                            count++;
                        } else {
                            pictureErrorElement3.html("");
                        }
                    }

                    if (count == 0) {

                        let form = $("#update-movie-form")[0];
                        let formData = new FormData(form);
                        formData.append("update_id", currentMovie);

                        if (pictureInput3.files.length == 0) {
                            $.ajax({
                                method: "POST",
                                url: url + "admin/updateMovie",
                                data: formData,
                                beforeSend: function() {
                                    waiting_message = Toast.open({
                                        type: 'info',
                                        message: "Just a moment...",
                                        background: 'blue',
                                        duration: 0,
                                    });
                                },
                                processData: false,
                                contentType: false,
                                success: function(responce) {
                                    closePopup("#backdrop",
                                        "#update-form",
                                        "backdrop-show",
                                        "form-show", ".duf"
                                    );
                                    Toast.dismiss(waiting_message);
                                    Toast.success(
                                        "The movie data has been updated successfully."
                                    );
                                    loadMovies();
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            });
                        } else {
                            $.ajax({
                                method: "POST",
                                url: url + "admin/updateMovie",
                                data: formData,
                                xhr: function() {
                                    // Create an XMLHttpRequest object with progress tracking
                                    var xhr = new XMLHttpRequest();
                                    xhr.upload.addEventListener(
                                        "progress",
                                        function(event) {
                                            if (event
                                                .lengthComputable
                                                ) {
                                                var percentComplete =
                                                    (event
                                                        .loaded /
                                                        event
                                                        .total
                                                        ) *
                                                    100;
                                                // Update your progress UI here
                                                $("#progressBar_update")
                                                    .val(
                                                        percentComplete
                                                        );
                                            }
                                        }, false);
                                    return xhr;
                                },
                                beforeSend: function() {
                                    $("#progressBar_update")
                                        .removeClass(
                                            "hideProgress");
                                    $("#progressTitle_update")
                                        .removeClass(
                                            "hideProgress");
                                    $("#backdrop").css(
                                        'pointer-events',
                                        'none');
                                    $("#updatemovie_popup_close")
                                        .css("display",
                                            "none");
                                },
                                processData: false,
                                contentType: false,
                                success: function(responce) {
                                    $("#progressBar_update")
                                        .addClass(
                                            "hideProgress");
                                    $("#progressTitle_update")
                                        .addClass(
                                            "hideProgress");
                                    $("#backdrop").css(
                                        'pointer-events', 'all');
                                    $("#updatemovie_popup_close")
                                        .css("display",
                                            "block");
                                    closePopup("#backdrop",
                                        "#update-form",
                                        "backdrop-show",
                                        "form-show", ".duf"
                                    );
                                    Toast.dismiss(waiting_message);
                                    Toast.success(
                                        "The movie data has been updated successfully."
                                    );
                                    loadMovies();
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            });
                        }
                    }

                });

            },
            error: function(err) {
                console.log(err);
            }
        });
    });
    $("#backdrop").on("click", function() {
        $("#insert-movie-form")[0].reset();
        closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
    });
    $("#updatemovie_popup_close").on("click", function() {
        $("#insert-movie-form")[0].reset();
        closePopup("#backdrop", "#update-form", "backdrop-show", "form-show", ".duf");
    });

    //delete
    $(document).on("click", "#delete_btn", function() {
        let delete_id = $(this).data('delete_id');
        let WaitingMessage;
        $.ajax({
            method: "GET",
            url: url + "admin/deleteMovie",
            data: {
                delete_id: delete_id,
            },
            beforeSend: function() {
                WaitingMessage = Toast.open({
                    type: 'info',
                    message: "Just a moment...",
                    background: 'blue',
                    duration: 0,
                });
            },
            success: function(responce) {
                Toast.dismiss(WaitingMessage);
                Toast.success("The movie has been successfully deleted.");
                loadMovies();
            },
            error: function(error) {
                console.log(error);
            }
        })
    });
});