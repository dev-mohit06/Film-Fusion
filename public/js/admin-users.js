const openPopupaddUser = document.getElementById("adduser_popup"),
    openPopupupdateUser = document.querySelectorAll(".updateuser_popup"),
    closePopupaddUser = document.getElementById("adduser_popup_close"),
    closePopupupdateUser = document.getElementById("updateuser_popup_close"),
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




const insertForm = document.getElementById("insert-user-form");
const updateForm = document.getElementById("updaet-user-form");

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
});

const updateForm_fields = [{
    name: 'update_username',
    regex: /^[a-zA-Z\_]+$/,
    error: 'Only characters A-Z, a-z and \'_\' are  acceptable.'
},
{
    name: 'update_email',
    regex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
    error: 'Please enter a valid email address.'
},
{
    name: 'update_password',
    regex: /^.{8,}$/,
    error: 'Password must be greater than or equals to 8 characters.'
},
{
    name: 'update_age',
    regex: /^\d+$/,
    error: 'Only digits are allowed.'
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

    const pictureInput = $("#update-profile_picture")[0];
    const pictureErrorElement = $("#err-update-profile_picture");
    if (pictureInput.files.length > 0) {
        const pictureFile = pictureInput.files[0];
        const allowedFormats = ["image/jpeg", "image/png"]; // Add more formats if needed

        if (pictureFile.size > 5 * 1024 * 1024) { // 5MB maximum size
            pictureErrorElement.html("The profile picture size exceeds the limit of 5MB.");
            count++;
        } else if (!allowedFormats.includes(pictureFile.type)) {
            pictureErrorElement.html("Please upload a profile picture in JPEG or PNG format.");
            count++;
        } else {
            pictureErrorElement.html("");
        }
    } else {
        pictureErrorElement.html("");
    }
});