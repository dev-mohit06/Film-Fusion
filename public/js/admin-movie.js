const openPopupaddUser = document.getElementById("addmovie_popup"),
    openPopupupdateUser = document.querySelectorAll(".updatemovie_popup"),
    closePopupaddUser = document.getElementById("addmovie_popup_close"),
    closePopupupdateUser = document.getElementById("updatemovie_popup_close"),
    backdropd = document.getElementById("backdrop");

let addForm_popup = document.getElementById("add-form");
let updateForm_popup = document.getElementById("update-form");



/* TODO: popup show and hide logic */

// User add popup form
openPopupaddUser.addEventListener("click", () => {
    addForm_popup.classList.add("form-show");
    backdropd.classList.add("backdrop-show");
});

closePopupaddUser.addEventListener("click", () => {
    addForm_popup.classList.remove("form-show");
    backdropd.classList.remove("backdrop-show");
});

backdropd.addEventListener("click", () => {
    addForm_popup.classList.remove("form-show");
    backdropd.classList.remove("backdrop-show");
});


// User update popup form
openPopupupdateUser.forEach((btn) => {
    btn.addEventListener("click", () => {
        updateForm_popup.classList.add("form-show");
        backdropd.classList.add("backdrop-show");
    });
});

closePopupupdateUser.addEventListener("click", () => {
    updateForm_popup.classList.remove("form-show");
    backdropd.classList.remove("backdrop-show");
});

backdropd.addEventListener("click", () => {
    updateForm_popup.classList.remove("form-show");
    backdropd.classList.remove("backdrop-show");
});


/* TODO: insert form validation */
//FIXME: In this fileds json object the name key is your id for you input.
const insertForm_fields = [{
    name: 'movie-name',
    regex: /^[a-zA-Z0-9\s]+$/,
    error: 'Only characters A-Z, a-z and numbers are acceptable.'
},
{
    name: 'movie-desc',
    regex: /^[a-zA-Z0-9\s]+$/,
    error: 'Only characters A-Z, a-z and numbers are acceptable.'
},
];

const insertForm = document.getElementById("insert-movie-form");

insertForm.addEventListener("submit", function (e) {
    e.preventDefault();
    let count = 0;
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
    // For hero-pic
    const pictureInput1 = $("#hero-pic")[0];
    const pictureErrorElement1 = $("#err-hero-pic");
    if (pictureInput1.files.length > 0) {
        const heroPic = pictureInput1.files[0];
        const allowedFormats = ["image/jpeg", "image/png"]; // Add more formats if needed

        if (heroPic.size > 5 * 1024 * 1024) { // 5MB maximum size
            pictureErrorElement1.html("The profile picture size exceeds the limit of 5MB.");
            count++;
        } else if (!allowedFormats.includes(heroPic.type)) {
            pictureErrorElement1.html("Please upload a profile picture in JPEG or PNG format.");
            count++;
        } else {
            pictureErrorElement1.html("");
        }
    } else {
        pictureErrorElement1.html("");
    }

    // For hero-pic
    const pictureInput2 = $("#banner")[0];
    const pictureErrorElement2 = $("#err-banner");
    if (pictureInput2.files.length > 0) {
        const banner = pictureInput2.files[0];
        const allowedFormats = ["image/jpeg", "image/png"]; // Add more formats if needed

        if (banner.size > 5 * 1024 * 1024) { // 5MB maximum size
            pictureErrorElement2.html("The profile picture size exceeds the limit of 5MB.");
            count++;
        } else if (!allowedFormats.includes(banner.type)) {
            pictureErrorElement2.html("Please upload a profile picture in JPEG or PNG format.");
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
        const allowedFormats = ["video/mp4", "video/x-matroska"]; // Add more formats if needed
        const file = pictureInput3.files[0];
        if (!allowedFormats.includes(file.type)) {
            pictureErrorElement3.html("Please upload a valid video file.");
            count++;
        } else {
            pictureErrorElement3.html("");
        }
    }
});

const updateForm = document.getElementById("updaet-movie-form");

const updateForm_fields = [{
    name: 'update-movie-name',
    regex: /^[a-zA-Z0-9\s]+$/,
    error: 'Only characters A-Z, a-z and numbers are acceptable.'
},
{
    name: 'update-movie-desc',
    regex: /^[a-zA-Z0-9\s]+$/,
    error: 'Only characters A-Z, a-z and numbers are acceptable.'
},
];


updateForm.addEventListener("submit", function (e) {
    e.preventDefault();
    let count = 0;
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
    // For hero-pic
    const pictureInput1 = $("#update-hero-pic")[0];
    const pictureErrorElement1 = $("#err-update-hero-pic");
    if (pictureInput1.files.length > 0) {
        const heroPic = pictureInput1.files[0];
        const allowedFormats = ["image/jpeg", "image/png"]; // Add more formats if needed

        if (heroPic.size > 5 * 1024 * 1024) { // 5MB maximum size
            pictureErrorElement1.html("The profile picture size exceeds the limit of 5MB.");
            count++;
        } else if (!allowedFormats.includes(heroPic.type)) {
            pictureErrorElement1.html("Please upload a profile picture in JPEG or PNG format.");
            count++;
        } else {
            pictureErrorElement1.html("");
        }
    } else {
        pictureErrorElement1.html("");
    }

    // For hero-pic
    const pictureInput2 = $("#update-banner")[0];
    const pictureErrorElement2 = $("#err-update-banner");
    if (pictureInput2.files.length > 0) {
        const banner = pictureInput2.files[0];
        const allowedFormats = ["image/jpeg", "image/png"]; // Add more formats if needed

        if (banner.size > 5 * 1024 * 1024) { // 5MB maximum size
            pictureErrorElement2.html("The profile picture size exceeds the limit of 5MB.");
            count++;
        } else if (!allowedFormats.includes(banner.type)) {
            pictureErrorElement2.html("Please upload a profile picture in JPEG or PNG format.");
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
        const allowedFormats = ["video/mp4", "video/x-matroska"]; // Add more formats if needed
        const file = pictureInput3.files[0];
        if (!allowedFormats.includes(file.type)) {
            pictureErrorElement3.html("Please upload a valid video file.");
            count++;
        } else {
            pictureErrorElement3.html("");
        }
    }
});