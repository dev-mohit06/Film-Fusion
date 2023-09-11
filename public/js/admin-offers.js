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