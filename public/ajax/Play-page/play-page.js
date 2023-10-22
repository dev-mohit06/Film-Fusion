$(document).ready(function () {

    // Show Video
    let playButton = $(".play-movie");
    let myvideo = $("#myvideo")[0];


    let likeCounter = $("#global-like");
    let dislikeCounter = $("#global-dislike");

    let like = $("#like");
    let dislike = $("#dislike");
    let watchLator = $("#watch-lator");
    let favorite = $("#favorite");


    function getAnalytics() {
        $.ajax({
            type: "GET",
            url: url + "user/getAnalytics",
            data: {
                movie_id: movie_id,
            },
            success: function (response) {
                likeCounter.html(response.analytics.likes);
                dislikeCounter.html(response.analytics.dislikes);

                if (response.is_respond) {
                    if (response.user_preference.is_liked) {
                        like.removeClass("bx-like");
                        like.addClass("bxs-like");
                    } else {
                        like.removeClass("bxs-like");
                        like.addClass("bx-like");
                    }

                    if (response.user_preference.is_disliked) {
                        dislike.removeClass("bx-dislike");
                        dislike.addClass("bxs-dislike");
                    } else {
                        dislike.removeClass("bxs-dislike");
                        dislike.addClass("bx-dislike");
                    }
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    }
    getAnalytics();

    function checkWatchLator() {
        $.ajax({
            type: "GET",
            url: url + "user/checkWatchLator",
            data: {
                user_id: user_id,
                movie_id: movie_id,
            },
            success: function (response) {
                if (response == "1") {
                    watchLator.removeClass("bx-list-plus");
                    watchLator.addClass("bx-list-check");
                } else {
                    watchLator.removeClass("bx-list-check");
                    watchLator.addClass("bx-list-plus");
                }
            }
        });
    }
    checkWatchLator();

    function checkFavorite() {
        $.ajax({
            type: "GET",
            url: url + "user/checkFavorite",
            data: {
                user_id: user_id,
                movie_id: movie_id,
            },
            success: function (response) {
                if (response == "1") {
                    favorite.removeClass("bx-heart");
                    favorite.addClass("bxs-heart");
                } else {
                    favorite.removeClass("bxs-heart");
                    favorite.addClass("bx-heart");
                }
            }
        });
    }
    checkFavorite();

    like.on("click", function () {
        $.ajax({
            type: "GET",
            url: url + "user/giveAnalytics",
            data: {
                movie_id: movie_id,
                btn: "like",
            },
            beforeSend: function () {
                if (like.hasClass("bx-like")) {
                    like.removeClass("bx-like");
                } else if (like.hasClass("bxs-like")) {
                    like.removeClass("bxs-like");
                }
                like.addClass("bx-loader-alt bx-spin");
            },
            success: function (response) {
                getAnalytics();
                like.removeClass("bx-loader-alt bx-spin");
            }
        });
    });

    dislike.on("click", function () {
        $.ajax({
            type: "GET",
            url: url + "user/giveAnalytics",
            data: {
                movie_id: movie_id,
                btn: "dislike",
            },
            beforeSend: function () {
                if (dislike.hasClass("bx-dislike")) {
                    dislike.removeClass("bx-dislike");
                } else if (dislike.hasClass("bxs-dislike")) {
                    dislike.removeClass("bxs-dislike");
                }
                dislike.addClass("bx-loader-alt bx-spin");
            },
            success: function (response) {
                getAnalytics();
                dislike.removeClass("bx-loader-alt bx-spin");
            }
        });
    });

    playButton.on("click", function () {
        myvideo.play();

        $.ajax({
            type: "GET",
            url: url + "user/recordUserHistory",
            data: {
                user_id: user_id,
                movie_id: movie_id,
            },
            success: function (e) {
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    watchLator.on("click", function () {
        $.ajax({
            type: "GET",
            url: url + "user/addWatchLator",
            data: {
                user_id: user_id,
                movie_id: movie_id,
            },
            beforeSend: function () {
                if (watchLator.hasClass("bx-plus-list")) {
                    watchLator.removeClass("bx-plus-list");
                } else if (watchLator.hasClass("bx-plus-check")) {
                    watchLator.removeClass("bx-plus-check");
                }
                watchLator.addClass("bx-loader-alt bx-spin");
            },
            success: function (response) {
                checkWatchLator();
                watchLator.removeClass("bx-loader-alt bx-spin");
            }
        });
    });

    favorite.on("click", function () {
        $.ajax({
            type: "GET",
            url: url + "user/addFavorite",
            data: {
                user_id: user_id,
                movie_id: movie_id,
            },
            beforeSend: function () {
                if (favorite.hasClass("bx-heart")) {
                    favorite.removeClass("bx-heart");
                } else if (favorite.hasClass("bxs-heart")) {
                    favorite.removeClass("bxs-heart");
                }
                favorite.addClass("bx-loader-alt bx-spin");
            },
            success: function (response) {
                checkFavorite();
                favorite.removeClass("bx-loader-alt bx-spin");
            }
        });
    });

});